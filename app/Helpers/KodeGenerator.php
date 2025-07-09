<?php

namespace App\Helpers;

class KodeGenerator
{
    /**
     * Generate kode otomatis seperti PTG01, M001, dsb.
     *
     * @param string $model - class model
     * @param string $column - nama kolom kode unik
     * @param string $prefix - awalan (misal: PTG, M, N)
     * @param int $digit - jumlah digit angka (misal: 2, 3)
     */
    public static function generate($model, $column, $prefix, $digit = 3)
    {
        $last = $model::orderBy($column, 'desc')->first();
        $lastNumber = $last ? intval(substr($last->$column, strlen($prefix))) : 0;
        $newNumber = $lastNumber + 1;
        return $prefix . str_pad($newNumber, $digit, '0', STR_PAD_LEFT);
    }
}
