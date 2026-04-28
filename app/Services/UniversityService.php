<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class UniversityService
{
    // ── Type badge colours (matches original) ──────────────────────
    public const TYPE_COLORS = [
        'SUC' => '#5ce38e', 'LUC' => '#48caea', 'PNS' => '#aa7df7',
        'PSC' => '#e98364', 'PSP' => '#9333ea', 'PSO' => '#7406cf',
        'TVI' => '#0f766e', 'SGO' => '#5a80e7',
    ];

    public const DEGREE_ORDER = [
        'Professional','Doctorate','Master','Bachelor','Associate','Certificate',
    ];

    // ── Lookups ────────────────────────────────────────────────────
    public function getStats(): array
    {
        return (array) DB::selectOne('SELECT * FROM v_dashboard_stats') ?? [];
    }

    public function getRegions(): \Illuminate\Support\Collection
    {
        return DB::table('regions')->orderBy('region_id')->get();
    }

    public function getUniversityTypes(): \Illuminate\Support\Collection
    {
        return DB::table('university_types')->orderBy('type_id')->get();
    }

    public function getCourses(): \Illuminate\Support\Collection
    {
        return DB::table('courses')->orderBy('degree_type')->orderBy('course_name')->get();
    }

    public function getAccredLevels(): \Illuminate\Support\Collection
    {
        return DB::table('accreditation_levels')->orderBy('accred_id')->get();
    }

    // ── University search ──────────────────────────────────────────
    public function searchUniversities(array $filters): \Illuminate\Support\Collection
    {
        $query = DB::table('universities as u')
            ->select([
                'u.university_id', 'u.university_name', 'u.abbreviation',
                'u.city', 'u.website', 'u.year_established',
                'ut.type_name', 'ut.type_code', 'ut.is_free_tuition',
                'al.level_name as accreditation', 'al.accred_id',
                DB::raw("COALESCE(p.province_name, u.city, 'Metro Manila') AS province_name"),
                DB::raw("COALESCE(r.region_name, 'NCR') AS region_name"),
                DB::raw("COALESCE(r.region_code, 'NCR') AS region_code"),
                DB::raw("(SELECT COUNT(*) FROM university_courses uc3
                          WHERE uc3.university_id = u.university_id
                          AND uc3.is_available = 1) AS courses_offered"),
            ])
            ->leftJoin('university_types as ut',     'u.type_id',     'ut.type_id')
            ->leftJoin('provinces as p',             'u.province_id', 'p.province_id')
            ->leftJoin('regions as r',               'p.region_id',   'r.region_id')
            ->leftJoin('accreditation_levels as al', 'u.accred_id',   'al.accred_id')
            ->where('u.is_active', 1)
            ->distinct()
            ->orderByDesc('ut.is_free_tuition')
            ->orderBy('u.university_name')
            ->limit(100);

        if (!empty($filters['q'])) {
            $kw = '%' . $filters['q'] . '%';
            $query->where(function ($q) use ($kw) {
                $q->where('u.university_name', 'like', $kw)
                  ->orWhere('u.abbreviation',  'like', $kw)
                  ->orWhere('u.city',          'like', $kw);
            });
        }
        if (!empty($filters['region']))   $query->where('r.region_id',   $filters['region']);
        if (!empty($filters['province']))  $query->where('u.province_id', $filters['province']);
        if (!empty($filters['type']))      $query->where('u.type_id',     $filters['type']);
        if (!empty($filters['accred']))    $query->where('u.accred_id',   $filters['accred']);
        if (!empty($filters['free']))      $query->where('ut.is_free_tuition', 1);
        if (!empty($filters['course'])) {
            $cid = $filters['course'];
            $query->whereExists(function ($sub) use ($cid) {
                $sub->select(DB::raw(1))
                    ->from('university_courses as uc2')
                    ->whereColumn('uc2.university_id', 'u.university_id')
                    ->where('uc2.course_id', $cid)
                    ->where('uc2.is_available', 1);
            });
        }

        return $query->get();
    }

    // ── Single university detail ────────────────────────────────────
    public function getUniversity(int $id): ?object
    {
        return DB::table('universities as u')
            ->select([
                'u.*',
                'ut.type_name', 'ut.type_code', 'ut.is_free_tuition',
                'al.level_name as accreditation', 'al.description as accred_desc',
                DB::raw("COALESCE(p.province_name, u.city, 'Metro Manila') AS province_name"),
                DB::raw("COALESCE(r.region_name, 'NCR') AS region_name"),
                DB::raw("COALESCE(r.region_code, 'NCR') AS region_code"),
            ])
            ->leftJoin('university_types as ut',     'u.type_id',     'ut.type_id')
            ->leftJoin('accreditation_levels as al', 'u.accred_id',   'al.accred_id')
            ->leftJoin('provinces as p',             'u.province_id', 'p.province_id')
            ->leftJoin('regions as r',               'p.region_id',   'r.region_id')
            ->where('u.university_id', $id)
            ->first();
    }

    public function getUniversityCourses(int $id): \Illuminate\Support\Collection
    {
        return DB::table('university_courses as uc')
            ->select([
                'co.course_code', 'co.course_name', 'co.degree_type',
                'co.years', 'co.board_exam',
                'uc.tuition_fee_per_semester', 'uc.misc_fees', 'uc.slots_per_year',
            ])
            ->join('courses as co', 'uc.course_id', 'co.course_id')
            ->where('uc.university_id', $id)
            ->where('uc.is_available', 1)
            ->orderBy('co.degree_type')
            ->orderBy('co.course_name')
            ->get();
    }

    public function getUniversityScholarships(int $id): \Illuminate\Support\Collection
    {
        return DB::table('university_scholarships as us')
            ->select([
                's.scholarship_name', 's.provider', 's.scholarship_type',
                's.coverage', 's.eligibility', 's.website',
            ])
            ->join('scholarships as s', 'us.scholarship_id', 's.scholarship_id')
            ->where('us.university_id', $id)
            ->where('s.is_active', 1)
            ->orderBy('s.scholarship_type')
            ->orderBy('s.scholarship_name')
            ->get();
    }

    // ── Region stats ───────────────────────────────────────────────
    public function getRegionStats(): \Illuminate\Support\Collection
    {
        return DB::table('regions as r')
            ->select([
                'r.region_id', 'r.region_code', 'r.region_name',
                DB::raw('COUNT(DISTINCT u.university_id) AS total_universities'),
                DB::raw('SUM(CASE WHEN ut.is_free_tuition=1 THEN 1 ELSE 0 END) AS free_tuition_schools'),
                DB::raw('SUM(CASE WHEN ut.is_free_tuition=0 AND u.university_id IS NOT NULL THEN 1 ELSE 0 END) AS private_schools'),
            ])
            ->leftJoin('provinces as p',       'p.region_id',   'r.region_id')
            ->leftJoin('universities as u',    function ($j) {
                $j->on('u.province_id', 'p.province_id')->where('u.is_active', 1);
            })
            ->leftJoin('university_types as ut', 'u.type_id', 'ut.type_id')
            ->groupBy('r.region_id', 'r.region_code', 'r.region_name')
            ->orderBy('r.region_id')
            ->get();
    }

    // ── Course finder ──────────────────────────────────────────────
    public function getCourseFinder(array $filters): \Illuminate\Support\Collection
    {
        $query = DB::table('university_courses as uc')
            ->select([
                'u.university_id', 'u.university_name', 'u.abbreviation', 'u.website',
                'co.course_code', 'co.course_name', 'co.degree_type', 'co.years', 'co.board_exam',
                'uc.tuition_fee_per_semester', 'uc.slots_per_year',
                'ut.type_code', 'ut.is_free_tuition',
                'al.level_name as accreditation',
                DB::raw("COALESCE(p.province_name, u.city, 'Metro Manila') AS province_name"),
                DB::raw("COALESCE(r.region_name, 'NCR') AS region_name"),
            ])
            ->join('universities as u',          'uc.university_id', 'u.university_id')
            ->join('courses as co',              'uc.course_id',     'co.course_id')
            ->leftJoin('university_types as ut', 'u.type_id',        'ut.type_id')
            ->leftJoin('accreditation_levels as al', 'u.accred_id',  'al.accred_id')
            ->leftJoin('provinces as p',         'u.province_id',    'p.province_id')
            ->leftJoin('regions as r',           'p.region_id',      'r.region_id')
            ->where('uc.is_available', 1)
            ->where('u.is_active', 1)
            ->orderBy('uc.tuition_fee_per_semester')
            ->orderBy('u.university_name')
            ->limit(200);

        if (!empty($filters['course'])) $query->where('co.course_id',  $filters['course']);
        if (!empty($filters['region']))  $query->where('r.region_id',   $filters['region']);
        if (!empty($filters['free']))    $query->where('uc.tuition_fee_per_semester', 0);
        if (!empty($filters['board']))   $query->where('co.board_exam', 1);

        return $query->get();
    }

    // ── Helper: format tuition ─────────────────────────────────────
    public static function formatTuition($amount): string
    {
        $n = (int) $amount;
        return $n === 0 ? 'Free (RA 10931)' : '₱' . number_format($n);
        // return $n === 0 ? 'Free (RA 10931)' : '₱' . number_format($n);
    }

    // ── Helper: type badge HTML ────────────────────────────────────
    public static function typeBadge(?string $code, ?string $name): string
    {
        $code  = $code  ?? '';
        $name  = $name  ?? '';
        $color = self::TYPE_COLORS[$code] ?? '#475569';
        return '<span class="badge" style="background:' . e($color) . '">'
             . e($code) . ' – ' . e($name) . '</span>';
    }
}
