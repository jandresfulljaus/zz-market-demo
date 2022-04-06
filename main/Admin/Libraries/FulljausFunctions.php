<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

if (!function_exists('set_input_form2')) 
{
    /**
     * @author Vicky Budiman vickzkater@gmail.com
     * 
     * for generate input element form
     */
    function set_input_form2($type, $input_name, $label_name, $data, $errors, $required = false, $config = null)
    {
        // declare default values
        $placeholder = null;
        $id_name = null;
        $value = null;
        $attributes = null;
        $defined_data = null;
        $no_image = asset('images/no-image.png');
        $delete = false;

        // set configuration
        if ($config) {
            if (isset($config->placeholder)) {
                $placeholder = $config->placeholder;
            }
            if (isset($config->id_name)) {
                $id_name = $config->id_name;
            }
            if (isset($config->value)) {
                $value = $config->value;
            }
            if (isset($config->attributes)) {
                $attributes = $config->attributes;
            }
            // config for textarea
            if (isset($config->rows)) {
                $textarea_rows = $config->rows;
            }
            // config for switch
            if (isset($config->default)) {
                $default = $config->default;
            }
            // config for select2
            if (isset($config->defined_data)) {
                $defined_data = $config->defined_data;
            }
            // config for select2
            if (isset($config->field_value)) {
                $field_value = $config->field_value;
            }
            // config for select2
            if (isset($config->field_text)) {
                $field_text = $config->field_text;
            }
            // config for select2
            if (isset($config->separator)) {
                $separator = $config->separator;
            }
            // config for number_format
            if (isset($config->input_addon)) {
                $input_addon = $config->input_addon;
            }
            // config for image
            if (isset($config->path)) {
                $path = $config->path;
            }
            // config for image
            if (isset($config->delete)) {
                $delete = $config->delete;
            }
            // config for image & file
            if (isset($config->info)) {
                $info = $config->info;
            }
        }

        // set error class
        $bad_item = '';
        if ($errors->has($input_name)) {
            $bad_item = 'bad item';
        }

        // set required in label
        $span_required = '';
        $required_status = '';
        if ($required) {
            $span_required = '<span class="required">*</span>';
            $required_status = 'required="required"';
        }

        // set value
        if (empty($value)) {
            if (old($input_name)) {
                $value = old($input_name);
            } elseif (isset($data->$input_name)) {
                $value = $data->$input_name;
            } elseif (isset($data[$input_name])) {
                $value = $data[$input_name];
            }
        }

        // set id element
        if (!$id_name) {
            $id_name = $input_name;
        }

        // pre-define element form input
        $element = '<div class="form-group row' . $bad_item . ' vinput_' . $input_name . '">';
        //$element .= '<label class="control-label col-md-3 col-sm-3 col-xs-12" for="' . $input_name . '">' . $label_name . ' ' . $span_required . '</label>';
        //$element .= '<div class="col-md-6 col-sm-6 col-xs-12">';
        $element .= '<label class="control-label col-sm-3" for="' . $input_name . '">' . $label_name . ' ' . $span_required . '</label>';
        $element .= '<div class="col-sm-9">';

        // set default properties of element input form
        $properties = 'name="' . $input_name . '" id="' . $id_name . '" placeholder="' . $placeholder . '" ' . $required_status . ' ' . $attributes;

        // set element input form
        switch ($type) {
            case 'hidden':
                $input_element = '<input type="hidden" value="' . $value . '" ' . $properties . ' />';
                break;

            case 'capital':
                $input_element = '<input type="text" value="' . $value . '" ' . $properties . ' class="form-control" style="text-transform: uppercase !important;" />';
                break;

            case 'number':
                $input_element = '<input type="number" value="' . $value . '" ' . $properties . ' class="form-control" />';
                break;

            case 'number_only':
                $input_element = '<input type="text" value="' . $value . '" ' . $properties . ' class="form-control" onkeyup="numbers_only(this);" />';
                break;

            case 'textarea':
                $attr = '';
                // set rows attribute
                if (isset($textarea_rows)) {
                    $attr = 'rows="' . (int) $textarea_rows . '"';
                }
                $input_element = '<textarea ' . $properties . ' ' . $attr . ' class="form-control">' . $value . '</textarea>';
                break;

            case 'switch':
                $checked = 'checked'; // default is checked
                if (empty($value)) {
                    $checked = '';
                    // set using default value: checked / ('') empty string
                    if (isset($default)) {
                        $checked = $default;
                    }
                }

                // for status or true/false (1/0)
                $values = ["0", "1"];
                if (empty($value) || in_array($value, $values)) {
                    if (isset($data->$input_name) && $data->$input_name == $values[0]) {
                        $checked = '';
                    } elseif (old($input_name) == $values[0]) {
                        $checked = '';
                    }
                    $input_element = '<div><label><input type="checkbox" class="js-switch" name="' . $input_name . '" id="' . $id_name . '" value="' . $values[1] . '" ' . $checked . ' ' . $attributes . ' /></label></div>';
                } else {
                    $input_element = '<div><label><input type="checkbox" class="js-switch" name="' . $input_name . '" id="' . $id_name . '" value="' . $value . '" ' . $checked . ' ' . $attributes . ' /></label></div>';
                }
                break;

            case 'datepicker':
                if ($value) {
                    if (strpos($value, '-') !== false) {
                        // convert date format
                        $date_arr = explode('-', $value);
                        if (count($date_arr) > 0) {
                            $date_formatted = $date_arr[2] . '/' . $date_arr[1] . '/' . $date_arr[0];
                            $value = $date_formatted;
                        }
                    }
                }
                $input_element = '<div class="input-group date input-datepicker" id="' . $id_name . '">';
                $input_element .= '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
                $input_element .= '<input type="text" value="' . $value . '" ' . $properties . ' class="form-control" autocomplete="off" /></div>';
                break;
                case 'select2':
                    $input_element = '<select ' . $properties . ' class="form-control select2">';
                    if (!empty($placeholder)) {
                        $input_element .= '<option value="" disabled selected>' . $placeholder . '</option>';
                    }
                    // set options
                    if (!empty($defined_data)) {
                        // default values
                        $set_value = 'id';
                        $set_label = 'name';
                        // set field for options value
                        if (isset($field_value)) {
                            $set_value = $field_value;
                        }
                        // set field for options text
                        if (isset($field_text)) {
                            $set_label = $field_text;
                            // if set options text more than 1 field
                            if (isset($separator)) {
                                $set_label = explode($separator, $field_text);
                            }
                        }
                        // set options
                        foreach ($defined_data as $item) {
                            // set "selected" attribute
                            $stats = '';
                            if ($item->$set_value == $value) {
                                $stats = 'selected';
                            }
    
                            // set options text
                            if (is_array($set_label)) {
                                // set options text more than 1 field
                                $labels = [];
                                foreach ($set_label as $val) {
                                    $labels[] = $item->$val;
                                }
                                $label = implode($separator, $labels);
                            } else {
                                // set options text using 1 field
                                $label = $item->$set_label;
                            }
                            // set HTML
                            $input_element .= '<option value="' . $item->$set_value . '" ' . $stats . '>' . $label . '</option>';
                        }
                    } else {
                        $input_element .= '<option value="" disabled>NO DATA</option>';
                    }
                    $input_element .= '</select>';
                    break;
    
                
            case 'selectmultiple':
                $input_element = '<select ' . $properties . ' class="form-control selectpicker" multiple data-live-search="true">';
                if (!empty($placeholder)) {
                    $input_element .= '<option value="" disabled selected>' . $placeholder . '</option>';
                }
                // set options
                if (!empty($defined_data)) {
                    // default values
                    $set_value = 'id';
                    $set_label = 'name';
                    // set field for options value
                    if (isset($field_value)) {
                        $set_value = $field_value;
                    }
                    // set field for options text
                    if (isset($field_text)) {
                        $set_label = $field_text;
                        // if set options text more than 1 field
                        if (isset($separator)) {
                            $set_label = explode($separator, $field_text);
                        }
                    }
                    // set options
                    foreach ($defined_data as $item) {
                        // set "selected" attribute
                        $stats = '';
                        if ($item->$set_value == $value) {
                            $stats = 'selected';
                        }

                        // set options text
                        if (is_array($set_label)) {
                            // set options text more than 1 field
                            $labels = [];
                            foreach ($set_label as $val) {
                                $labels[] = $item->$val;
                            }
                            $label = implode($separator, $labels);
                        } else {
                            // set options text using 1 field
                            $label = $item->$set_label;
                        }
                        // set HTML
                        $input_element .= '<option value="' . $item->$set_value . '" ' . $stats . '>' . $label . '</option>';
                    }
                } else {
                    $input_element .= '<option value="" disabled>NO DATA</option>';
                }
                $input_element .= '</select>';
                break;

            case 'select':
                $input_element = '<select ' . $properties . ' class="form-control">';
                if (!empty($placeholder)) {
                    $input_element .= '<option value="" disabled selected>' . $placeholder . '</option>';
                }
                // set options
                if (!empty($defined_data)) {
                    foreach ($defined_data as $key => $val) {
                        $stats = '';
                        if ($key == $value && !empty($value)) {
                            $stats = 'selected';
                        }

                        $input_element .= '<option value="' . $key . '" ' . $stats . '>' . $val . '</option>';
                    }
                } else {
                    $input_element .= '<option value="" disabled>NO DATA</option>';
                }
                $input_element .= '</select>';
                break;

            case 'number_format':
                // sanitize the value, so it must be numeric
                $value = (int) str_replace(',', '', $value);

                $input_element = '<input type="text" value="' . number_format($value) . '" ' . $properties . ' class="form-control" onkeyup="numbers_only(this);this.value=number_format(this.value);" />';
                break;

            case 'image':
                if (empty($value)) {
                    // default image
                    $input_element = '<img src="' . $no_image . '" style="max-width:200px;" />';
                } else {
                    // set image using "$value" only
                    $img_src = asset($value);
                    if (isset($path)) {
                        // set image using "$path" & "$value"
                        $img_src = asset($path . $value);
                    }
                    $input_element = '<img src="' . $img_src . '" style="max-width:200px;" />';
                }
                $input_element .= '<input type="file" ' . $properties . ' class="form-control" accept="image/*" onchange="readURL(this, \'before\');" style="margin-top:5px" />';
                if (isset($info)) {
                    $input_element .= '<br><span><i class="fa fa-info-circle"></i>&nbsp; ' . $info . '</span>';
                }
                if (!empty($value) && $delete) {
                    $input_element .= '<br><span class="btn btn-warning btn-xs" id="' . $id_name . '-delbtn" style="margin: 5px 0 !important;" onclick="reset_img_preview(\'#' . $id_name . '\', \'' . $no_image . '\', \'before\')">Delete uploaded image?</span>';
                    $input_element .= ' <input type="hidden" name="' . $input_name . '_delete" id="' . $input_name . '-delete">';
                }
                break;

            case 'tags':
                $input_element = '<input type="text" class="tags tagsinput form-control" value="' . $value . '" ' . $properties . ' />';
                break;

            case 'email':
                $input_element = '<input type="email" value="' . $value . '" ' . $properties . ' class="form-control" />';
                break;

            case 'password':
                $input_element = '<input type="password" value="' . $value . '" ' . $properties . ' class="form-control" />';
                break;

            case 'word':
                $input_element = '<input type="text" value="' . $value . '" ' . $properties . ' class="form-control" onkeyup="username_only(this);" />';
                break;

            case 'file':
                $input_element = '';
                if (!empty($value)) {
                    $input_element .= '<a href="' . asset($value) . '" target="_blank" id="' . $id_name . '-file-preview">' . $value . '</a>';
                    if ($delete) {
                        $input_element .= '&nbsp; <span class="btn btn-danger btn-xs" id="' . $id_name . '-delbtn" style="margin: 5px 0 !important;" onclick="remove_uploaded_file(\'#' . $id_name . '\')"><i class="fa fa-trash"></i></span><br>';
                        $input_element .= ' <input type="hidden" name="' . $input_name . '_delete" id="' . $input_name . '-delete">';
                    }
                }
                if (isset($info)) {
                    $input_element .= '<span><i class="fa fa-info-circle"></i>&nbsp; ' . $info . '</span><br>';
                }
                $input_element .= '<input type="file" ' . $properties . ' class="form-control" />';
                break;

            default:
                // text
                $input_element = '<input type="text" value="' . $value . '" ' . $properties . ' class="form-control" />';
                break;
        }

        // set input group addon
        if (isset($input_addon)) {
            $element .= '<div class="input-group">';
            $element .= '<span class="input-group-addon">' . $input_addon . '</span>';
            $element .= $input_element;
            $element .= '</div>';
        } else {
            $element .= $input_element;
        }

        // set error message
        if ($errors->has($input_name)) {
            $element .= '<div class="text-danger">' . $errors->first($input_name) . '</div>';
        }
        $element .= '</div></div>';

        // special case
        if ($type == 'hidden') {
            $element = $input_element;
        }

        return $element;
    }
}
