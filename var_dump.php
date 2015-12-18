<?php


if(!function_exists('in_dev')) {
    /**
     * Function used to display some informations for the developer
     *
     * @return bool
     */
    function in_dev()
    {
        // Here put your office/home IP address so that the dump will be only seen by you and your team
        $devAdress = ['YOUR.IP.ADDRESS.HERE', '127.0.0.1', '::1', 'localhost'];

        return in_array($_SERVER['REMOTE_ADDR'], $devAdress);
    }
}


// Differents cases for the vardump function

// The vardump function only returns in a string the var_dump data (usefull for pages needing reload)
const ONLY_RETURN = 0;

// The vardump function returns only display the accordeon
const ONLY_DISPLAY = 1;

// The vardump function returns in a string the var_dump data and display the accordeon (Default case)
const RETURN_AND_DISPLAY = 2;

/**
 *
 * Used to dump data in accordeon
 *
 * @param null $var
 * @param int $return
 * @return string
 */
function vardump($var = null,$return = RETURN_AND_DISPLAY)
{
    if (in_dev()) {
        if($return == ONLY_DISPLAY || $return == RETURN_AND_DISPLAY) {
            ?>
            <div class="panel panel-default" style="position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 100;
    margin-bottom: 0;">
                <div class="panel-heading" style="padding: 0;">
                    <h4 class="panel-title">
                        <a class="collapsed" style="display: block; padding: 10px;" role="button" data-toggle="collapse"
                           href="#collapse" aria-expanded="false" aria-controls="collapse">
                            Vardump Data
                        </a>
                    </h4>
                </div>
                <div id="collapse" style="max-height: 400px; overflow-y: scroll;" class="panel-collapse collapse"
                     role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <?php if (isset($var)) {
                            do_dump($var);
                        } else
                            echo 'NULL'; ?>
                    </div>
                </div>
            </div>
            <?php
        }
        if($return == ONLY_RETURN ||$return == RETURN_AND_DISPLAY) {
            ob_start();
            var_dump($var);
            $a = ob_get_contents();
            ob_end_clean();
            return $a;
        }
    }
}




/**
 * Better GI than print_r or var_dump -- but, unlike var_dump, you can only dump one variable.
 * Added htmlentities on the var content before echo, so you see what is really there, and not the mark-up.
 *
 * Also, now the output is encased within a div block that sets the background color, font style, and left-justifies it
 * so it is not at the mercy of ambient styles.
 *
 * Inspired from:     PHP.net Contributions
 * Stolen from:       [highstrike at gmail dot com]
 * Modified by:       stlawson *AT* JoyfulEarthTech *DOT* com
 *
 * @param mixed $var  -- variable to dump
 * @param string $var_name  -- name of variable (optional) -- displayed in printout making it easier to sort out what variable is what in a complex output
 * @param string $indent -- used by internal recursive call (no known external value)
 * @param unknown_type $reference -- used by internal recursive call (no known external value)
 */
function do_dump(&$var, $var_name = NULL, $indent = NULL, $reference = NULL)
{
    $do_dump_indent = "<span style='color:#666666;'>|</span> &nbsp;&nbsp; ";
    $reference = $reference.$var_name;
    $keyvar = 'the_do_dump_recursion_protection_scheme'; $keyname = 'referenced_object_name';

// So this is always visible and always left justified and readable
    echo "<div style='text-align:left; background-color:white; font: 100% monospace; color:black;'>";

    if (is_array($var) && isset($var[$keyvar]))
    {
        $real_var = &$var[$keyvar];
        $real_name = &$var[$keyname];
        $type = ucfirst(gettype($real_var));
        echo "$indent$var_name <span style='color:#666666'>$type</span> = <span style='color:#e87800;'>&amp;$real_name</span><br>";
    }
    else
    {
        $var = array($keyvar => $var, $keyname => $reference);
        $avar = &$var[$keyvar];

        $type = ucfirst(gettype($avar));
        if($type == "String") $type_color = "<span style='color:green'>";
        elseif($type == "Integer") $type_color = "<span style='color:red'>";
        elseif($type == "Double"){ $type_color = "<span style='color:#0099c5'>"; $type = "Float"; }
        elseif($type == "Boolean") $type_color = "<span style='color:#92008d'>";
        elseif($type == "NULL") $type_color = "<span style='color:black'>";

        if(is_array($avar))
        {
            $count = count($avar);
            echo "$indent" . ($var_name ? "$var_name => ":"") . "<span style='color:#666666'>$type ($count)</span><br>$indent(<br>";
            $keys = array_keys($avar);
            foreach($keys as $name)
            {
                $value = &$avar[$name];
                do_dump($value, "['$name']", $indent.$do_dump_indent, $reference);
            }
            echo "$indent)<br>";
        }
        elseif(is_object($avar))
        {
            echo "$indent$var_name <span style='color:#666666'>$type</span><br>$indent(<br>";
            foreach($avar as $name=>$value) do_dump($value, "$name", $indent.$do_dump_indent, $reference);
            echo "$indent)<br>";
        }
        elseif(is_int($avar)) echo "$indent$var_name = <span style='color:#666666'>$type(".strlen($avar).")</span> $type_color".htmlentities($avar)."</span><br>";
        elseif(is_string($avar)) echo "$indent$var_name = <span style='color:#666666'>$type(".strlen($avar).")</span> $type_color\"".htmlentities($avar)."\"</span><br>";
        elseif(is_float($avar)) echo "$indent$var_name = <span style='color:#666666'>$type(".strlen($avar).")</span> $type_color".htmlentities($avar)."</span><br>";
        elseif(is_bool($avar)) echo "$indent$var_name = <span style='color:#666666'>$type(".strlen($avar).")</span> $type_color".($avar == 1 ? "TRUE":"FALSE")."</span><br>";
        elseif(is_null($avar)) echo "$indent$var_name = <span style='color:#666666'>$type(".strlen($avar).")</span> {$type_color}NULL</span><br>";
        else echo "$indent$var_name = <span style='color:#666666'>$type(".strlen($avar).")</span> ".htmlentities($avar)."<br>";

        $var = $var[$keyvar];
    }

    echo "</div>";
}
