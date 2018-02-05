<?php

namespace App\Helpers;


class Translit
{
    public static function translit($string)
    {
        $str = mb_strtolower($string, 'UTF-8');

        $letter_array = array(
            'a' => 'а',
            'b' => 'б',
            'v' => 'в',
            'g' => 'г,ґ',
            'd' => 'д',
            'e' => 'е,є,э',
            'jo' => 'ё',
            'zh' => 'ж',
            'z' => 'з',
            'i' => 'и,і',
            'ji' => 'ї',
            'j' => 'й',
            'k' => 'к',
            'l' => 'л',
            'm' => 'м',
            'n' => 'н',
            'o' => 'о',
            'p' => 'п',
            'r' => 'р',
            's' => 'с',
            't' => 'т',
            'u' => 'у',
            'f' => 'ф',
            'kh' => 'х',
            'ts' => 'ц',
            'ch' => 'ч',
            'sh' => 'ш',
            'shch' => 'щ',
            '' => 'ъ',
            'y' => 'ы',
            '' => 'ь',
            'yu' => 'ю',
            'ya' => 'я',
        );

        foreach($letter_array as $letter => $kyr) {
            $kyr = explode(',',$kyr);

            $str = str_replace($kyr,$letter, $str);

        }
        //  A-Za-z0-9-
        $str = preg_replace('/(\s|[^A-Za-z0-9\-])+/','-',$str);

        $str = trim($str,'-');

        return $str;
    }
}