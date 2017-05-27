<?php

namespace AppBundle\Twig;

class I18nExtension extends \Twig_Extension
{
    private static $fallback = 'fr';
    private static $format   = array(
        'en'    => ':',
        'fr'    => 'h',
    );

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('formatTime', array($this, 'formatTime')),
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
            new \Twig_SimpleFilter('formatSingleDayPart', array($this, 'formatSingleDayPart')),
        );
    }

    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        return $price . ' €';
    }

    public static function get($locale)
    {
        return (self::$format[$locale])? : self::$format[self::$fallback];
    }

    public static function getDefault()
    {
        return self::get(\Locale::getDefault());
    }

    public static function formatTime($time, $format = ':')
    {
        $timeParts = explode($format, $time);

        if (1 === count($timeParts)) {
            throw new \Exception('You did not used a format such as :');
        }

        return $timeParts[0] . self::getDefault() . $timeParts[1];
    }

    public static function formatSingleDayPart($daypart)
    {
        $daypartParts = explode('-', $daypart);

        if (1 === count($daypartParts)) {
            throw new \Exception('You did not used a separator such as -');
        }

        $tempDayPart        = self::constructDayPart($daypartParts);
        return implode('-', $tempDayPart);
    }

    private static function constructDayPart($daypartParts)
    {
        $tempDayPart = array();

        foreach ($daypartParts as $hour) {
            $hour = str_pad($hour, 2, '0', STR_PAD_LEFT) . self::getDefault();

            if ('en' == \Locale::getDefault()) {
                $hour .= '00';
            }
            $tempDayPart[] = $hour;
        }

        return $tempDayPart;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'i18n_extension';
    }

}