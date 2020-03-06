<?php
/**
 * Created by OOO 1C-SOFT.
 * User: Dremin_S
 * Date: 06.03.2020
 */

namespace Soft1c\Date;


use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;

class Date extends Carbon
{

    /**
     * Alias for diffForHumans.
     *
     * @param Date $since
     * @param bool $syntax Removes time difference modifiers ago, after, etc
     * @param bool $short (Carbon 2 only) displays short format of time units
     * @param int $parts (Carbon 2 only) maximum number of parts to display (default value: 1: single unit)
     * @param int $options (Carbon 2 only) human diff options
     *
     * @return string
     */
    public function ago($since = null, $syntax = null, $short = false, $parts = 1, $options = null)
    {
        return $this->diffForHumans($since, $syntax, $short, $parts, $options);
    }

    /**
     * Alias for diffForHumans.
     *
     * @param Date $since
     * @param bool $syntax Removes time difference modifiers ago, after, etc
     * @param bool $short (Carbon 2 only) displays short format of time units
     * @param int $parts (Carbon 2 only) maximum number of parts to display (default value: 1: single unit)
     * @param int $options (Carbon 2 only) human diff options
     *
     * @return string
     */
    public function until($since = null, $syntax = null, $short = false, $parts = 1, $options = null)
    {
        return $this->ago($since, $syntax, $short, $parts, $options);
    }

    public function format($format)
    {
        $replace = [];

        if ($this->locale == 'en')
            return parent::format($format);

        $lang = $this->currentTranslator($this->getLocaleMassages());

        // Loop all format characters and check if we can translate them.
        for ($i = 0; $i < strlen($format); $i++) {
            $character = $format[$i];

            // Check if we can replace it with a translated version.
            if (in_array($character, ['D', 'l', 'F', 'M'])){
                // Check escaped characters.
                if ($i > 0 and $format[$i - 1] == '\\'){
                    continue;
                }

                switch ($character) {
                    case 'D':
                        $key = parent::format('l');
                        break;
                    case 'M':
                        $key = parent::format('F');
                        break;
                    default:
                        $key = parent::format($character);
                }

                $key = 'date.'.Str::lower($key);
                // The original result.
                $original = parent::format($character);

                if (in_array($character, ['F', 'M'])){
                    $choice = preg_match('#[dj][ .]*$#', substr($format, 0, $i)) ? 1 : 0;
                    $translated = $lang->choice($key, $choice);
                } elseif ($character == 'M') {
                    $translated = $lang->get('date.short.'.Str::lower($key));
                } else {
                    $translated = $lang->get($key);
                }

                // Short notations.
                if (in_array($character, ['D', 'M'])){
                    $toTranslate = Str::lower($original);
                    $shortTranslated = $lang->get($toTranslate);

                    if ($shortTranslated === $toTranslate){
                        // use the first 3 characters as short notation
                        $translated = mb_substr($translated, 0, 3);
                    } else {
                        // use translated version
                        $translated = $shortTranslated;
                    }
                }

                // Add to replace list.
                if ($translated and $original != $translated){
                    $replace[$original] = $translated;
                }
            }
        }

        // Replace translations.
        if ($replace){
            return str_replace(array_keys($replace), array_values($replace), parent::format($format));
        }

        return parent::format($format);
    }

    /**
     * @method getLocaleMassages
     * @return array
     */
    public function getLocaleMassages()
    {
        $fileProject = app_path('resources/lang/'.$this->locale.'/date.php');
        if (file_exists($fileProject)){
            return require($fileProject);
        }
        $fileProject = require(__DIR__.'/resources/lang/date/'.$this->locale.'.php');

        return $fileProject;
    }

    /**
     * @method currentTranslator
     * @param array $messages
     *
     * @return Translator
     */
    public function currentTranslator(array $messages = []): Translator
    {
        $loader = new ArrayLoader();
        $loader->addMessages($this->locale, 'date', $messages);

        return new Translator($loader, $this->locale);
    }
}
