<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('normalisasi_angka')) {
    function normalisasi_angka($value)
    {
        if ($value === '-' || $value === '' || $value === null) {
            return null;
        }

        // Hapus titik ribuan (1.234,56 → 1234,56)
        $value = str_replace('.', '', $value);

        // Ubah koma ke titik (1234,56 → 1234.56)
        $value = str_replace(',', '.', $value);

        return is_numeric($value) ? $value : null;
    }
}