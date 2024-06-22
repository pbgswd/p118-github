<?php

//view_helpers.php

if (! function_exists('store_datum')) {
    function store_datum($key, $value)
    {
        global $stored_data;
        $stored_data[$key] = $value;
    }
}

if (! function_exists('get_datum')) {
    function get_datum($key)
    {
        global $stored_data;

        return $stored_data[$key];
    }
}

if (! function_exists('checked')) {
    function checked($a, $b = null)
    {
        $test = ((func_num_args() == 1) ? ((bool) $a) : ($a == $b));
        echo $test ? ' checked="checked" ' : '';
    }
}

if (! function_exists('selected')) {
    function selected($a, $b = null)
    {
        $test = ((func_num_args() == 1) ? ((bool) $a) : ($a == $b));
        echo $test ? ' selected="selected"' : '';
    }
}

if (! function_exists('select_options')) {
    /**
     * modified from Smarty's {{html_options}} - Smarty/plugins/function.html_options.php.
     *
     * @param  array  $data  Associative array of keys and display values for the dropdown options.
     * @param  mixed  $selected  (array or string) Key value of selected option(s).
     * @param  mixed  $attributes  (array or string) List of attributes for <select> tag.
     *                             (boolean) If TRUE, open and close <select> tag will be added with no attributes.
     *                             (boolean) If FALSE, open and close <select> tag will be omitted.
     *
     * @usage   {{ select_options($data['countries'], $user->country_code, ['name' => 'user[country_code]',
     * 'class' => 'xs_selectbox']) }}
     */
    function select_options(array $data, $selected = null, $attributes = true, $required = null)
    {
        $placeholder = null;
        if ($attributes === false) {
            $result = '';
            $closeTag = "\n";
        } else {
            $result = '<select class="form-control" ';
            $closeTag = "</select>\n";
            if (is_array($attributes)) {
                foreach ($attributes as $name => $value) {
                    $result .= ' '.$name.'="'.htmlspecialchars($value).'" ';
                    if ($name === 'placeholder') {
                        $placeholder = _select_opt_output(null, $value, [], ' selected="selected"');
                    }
                }
            } elseif ($attributes !== true) {
                //todo: todoRTL: pull 'placeholder' text from $attributes string
                $result .= $attributes;
            }
            $result .= $required.">\n";
        }

        if ($placeholder) {
            $result .= $placeholder;
        }

        $selected = array_map('strval', array_values((array) $selected));

        foreach ($data as $key => $val) {
            $result .= _select_opt_output((string) $key, $val, $selected);
        }

        $result .= $closeTag;

        echo $result;
    }

    /**
     * @param  string  $optAttributes
     * @return string
     */
    function _select_opt_output($value, $label, $selected, $optAttributes = '')
    {
        if (is_array($label)) {
            $html = _select_optgroup_output($value, $label, $selected);
        } else {
            $html = '<option label="'.htmlspecialchars($label)
                .'" value="'
                .htmlspecialchars($value)
                .'" '
                .$optAttributes;

            if (in_array($value, $selected)) {
                $html .= ' selected="selected"';
            }
            $html .= '>'.htmlspecialchars($label)."</option>\n";
        }

        return $html;
    }

    /**
     * @return string
     */
    function _select_optgroup_output($group_label, array $subarray, $selected)
    {
        $optgroup_html = '<optgroup label="'.htmlspecialchars($group_label).'">'."\n";
        foreach ($subarray as $value => $label) {
            $optgroup_html .= _select_opt_output((string) $value, $label, $selected);
        }
        $optgroup_html .= "</optgroup>\n";

        return $optgroup_html;
    }
}
