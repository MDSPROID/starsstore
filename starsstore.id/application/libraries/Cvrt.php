<?php class Cvrt
{
    /**
     * Format Rupiah
     * 
     * @param string $string The string to encrypt.
     * @param string $key[optional] The key to encrypt with.
     * @param bool $url_safe[optional] Specifies whether or not the
     *                returned string should be url-safe.
     * @return string
     */
    function cvrttorupiah($angka)
    {
       format_number($angka, 2, ‘,’ , ‘.’ );
    }
}
?>