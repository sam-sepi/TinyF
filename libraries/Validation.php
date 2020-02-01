<?php

namespace TinyF\Libraries;

/** 
 *  @class Validation
 *  
 */

class Validation
{
    /**
     * @fn getString 
     * 
     * Ex.: 
     * $validation->getString
     * (
     *    $validation->getFilteredString($_POST['username']), 5, 29
     * );
     * 
     * @param  string|null $string input
     * @param  int|null    $min    min chars.
     * @param  int|null    $max    max chars.
     * @return bool
     *
     */
    public function getString(string $string = null, int $min = null, int $max = null): bool
    {
        $string = preg_replace('/\s+/', '', $string);

        if(!is_string($string)) return false;

        if((isset($min)) && (strlen($string) < $min)) return false;

        if((isset($max)) && (strlen($string) > $max)) return false;

        return true;
    }

    /**
     * @fn getAlpha 
     * 
     * @param  string|null $string input
     * @param  int|null    $min chars
     * @param  int|null    $max chars
     * @return bool
     */
    public function getAlpha(string $string = null, int $min = null, int $max = null): bool
    {
        if(!ctype_alpha($string)) return false;

        if((isset($min)) && (strlen($string) < $min)) return false;

        if((isset($max)) && (strlen($string) > $max)) return false;

        return true;
    }

    /**
     * @fn getEmail 
     * 
     * Ex.: $validation->getEmail($_POST['email']);
     * 
     * @param  string|null $email input
     * @param  int|null    $min   min chars
     * @param  int|null    $max   max chars
     * @return bool
     */
    public function getEmail(string $email = null, int $min = null, int $max = null): bool
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;

        // domains banned
        $bannedEmails = json_decode(file_get_contents(__DIR__ . "/domains/domains.json"));

        if(in_array(strtolower(explode('@', $email)[1]), $bannedEmails)) return false;

        if((isset($min)) && (strlen($email) < $min)) return false;

        if((isset($max)) && (strlen($email) > $max)) return false;

        return true;
    }

    /**
     * @fn getPassword 
     * 
     * @param  string|null $password input
     * @param  int|integer $min      min len
     * @param  int|integer $max      max len
     * @return bool
     */
    public function getPassword(string $password = null, int $min = 8, int $max = 16): bool
    {
        // len
        if(strlen($password) < $min || strlen($max) > 16) 
        {
            return false;
        }

        // digit
        if (!preg_match("/\d/", $password)) 
        {
            return false;
        }

        // upper
        if (!preg_match("/[A-Z]/", $password)) 
        {
            return false;
        }

        // lower
        if (!preg_match("/[a-z]/", $password)) 
        {
            return false;
        }

        // special chars
        if (!preg_match("/\W/", $password)) 
        {
            return false;
        }

        // no ws
        if (preg_match("/\s/", $password)) 
        {
            return false;
        }

        return true;
    }

    /**
     * @fn matches 
     * Ex.: $validation->matches($_POST['password'], $_POST['confirm_password']);
     * 
     * @param  string|null $string  input
     * @param  string|null $confstr input
     * @return bool
     */
    public function matches(string $string = null, string $confstr = null): bool
    {
        $string = preg_replace('/\s+/', '', $string);

        if($string == null) return false;

        if($string === $confstr) return true;

        return false;
    }

    /**
     * @fn htmlValidate 
     * 
     * credit: https://github.com/GDRCD/GDRCD
     * 
     * @param  string|null $string  input
     * @param  bool  $max_security
     * 
     * @return string|null
     *
     */
    public function htmlValidate(string $string = null, bool $max_security = true)
    {
        $notAllowed = 
            [
                "#(<script.*?>.*?(<\/script>)?)#is"     => "No script",
                "#(<iframe.*?\/?>.*?(<\/iframe>)?)#is"  => "No Frame",
                "#(<object.*?>.*?(<\/object>)?)#is"     => "No object content",
                "#(<embed.*?\/?>.*?(<\/embed>)?)#is"    => "No embed content",
                "#( on[a-zA-Z]+=\"?'?[^\s\"']+'?\"?)#is"=> "",
                "#(javascript:[^\s\"']+)#is"            => ""
            ];
  
        if($max_security == true)
        {
            $notAllowed = array_merge($notAllowed,
                [
                    "#(<img.*?\/?>)#is" => "No Img.",
                    "#(url\(.*?\))#is"  => "none"
                ]
            );
        }
    
        return preg_replace(array_keys($notAllowed), array_values($notAllowed), $string);
    }

    /**
     * @fn closeHtmlTags 
     * 
     * credit: https://gist.github.com/JayWood/348752b568ecd63ae5ce
     * 
     * Ex.: $validation->closeHtmlTags($_POST['article']);
     *  
     * @param  string|null $string     input
     * @return strin|null
     *
     */
    public function closeHtmlTags(string $string = null) 
    {
        preg_match_all("#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU", $string, $result);
        
        $openedtags = $result[1];
        
        preg_match_all('#</([a-z]+)>#iU', $string, $result);
        
        $closedtags = $result[1];
        
        $len_opened = count($openedtags);
        
        if(count($closedtags) == $len_opened) 
        {
            return $string;
        }
    
        $openedtags = array_reverse($openedtags);
    
        for ($i=0; $i < $len_opened; $i++) 
        {
            
            if(!in_array($openedtags[$i], $closedtags)) 
            {
            
                $string .= '</'.$openedtags[$i].'>';
            
            }else 
            {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
    
        return $string;
    }

    /**
     * @fn getFilteredString 
     * 
     * @param  string|null
     * @return string|null filtered string
     */
    public function getFilteredString(string $string = null)
    {
        $string = (isset($string)) ? filter_var($string, FILTER_SANITIZE_STRING) : null;

        return $string;
    }

    /**
     * @fn getAlNum 
     * 
     * @param  string|null $string input
     * @param  int|null    $min    min chars
     * @param  int|null    $max    max chars
     * @return bool
     */
    public function getAlNum(string $string = null, int $min = null, int $max = null): bool
    {
        if(!ctype_alnum($string)) return false;

        if((isset($min)) && (strlen($string) < $min)) return false;

        if((isset($max)) && (strlen($string) > $max)) return false;

        return true;
    }
}

?>