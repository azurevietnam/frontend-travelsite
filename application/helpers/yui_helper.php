<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * YUI Compressor 2.4.8
 *
 * Compress css and javascript files
 *
 * @author toanlk
 * @since  Nov 14, 2014
 */
if (! function_exists('yui_compressor'))
{
    function yui_compressor($files, $minify_name = '')
    {
        // Set timezone
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        
        $time = date('dmYHi');
        
        $temp_files_dir = FCPATH . 'system';
        
        $jar_path = APPPATH . '/libraries/yuicompressor.jar';
        
        // Get file type: default is css
        $type = 'css';
        
        if (stripos($files, '.js') !== false)
        {
            $type = 'js';
        }
        
        // INCLUDE COMPRESSOR CLASS
        require_once dirname(__FILE__) . '/../libraries/yuicompressor.php';
        
        $options = array(
            'type' => $type
        );
        
        // INVOKE CLASS
        $yui = new YUICompressor($jar_path, $temp_files_dir, $options);
        
        // Get file content
        $files = explode(',', $files);
        
        $compresstext = '';
        
        foreach ($files as $file_name)
        {
            $file_path = FCPATH . $type . '\\' . $file_name;
            
            // ADD FILES : $absolute_path_to_file
            $yui->addFile($file_path);
            
            $compresstext .= file_get_contents($file_path);
        }
        
        if(empty($minify_name))
        {
            $minify_name = str_replace('.'.$type, '.min.' . $time . '.'.$type, $last = end($files));
        }

        $minify_path = FCPATH . $type . '\\' . $minify_name;

        // ADD STRING
        // $yui->addString($string);
        
        // COMPRESS
        $code = $yui->compress();
        
        file_put_contents($minify_path, $code);
        
        $before = string_size($compresstext);
        
        $after = string_size($code);
        
        $ratio = number_format(($before - $after) / $before * 100, 0);
        
        $msg = '<!DOCTYPE html>
                <html>
                <body>
                <style>
                    body { padding: 50px; font-family: Arial; font-size: 12px; }
                    h1 { margin: 0; padding: 0; font-size: 24px; text-align: left; font-weight: normal }
                    .yui-table { border-collapse: collapse; border-spacing: 0; font-size: 12px; }
                    .yui-table thead { background-color: #0f9d58; color: #fff }
                    .yui-table td, .yui-table th {
                        border: 1px solid #0f9d58 !important;
                        padding: 10px 15px;
                    }
                    .minify-name { border: 0; width: 300px; color: #4285F4 }
                </style>
                <table class="yui-table">
                    <thead>
                        <th colspan="2"><h1>YUI Compressor 2.4.8</h1></th>
                    </thead>
                	<tbody>
                		<tr>
                			<td>source</td>
                			<td>' . implode(',', $files) . '</td>
                		</tr>
                		<tr>
                			<td>minify</td>
                			<td><input onClick="this.focus();this.select();" type="text" value="'.$minify_name.'" class="minify-name" id="minify-name"></td>
                		</tr>
                		<tr>
                			<td>before</td>
                			<td>' . $before . '</td>
                		</tr>
                		<tr>
                			<td>after compression</td>
                			<td>' . $after . '</td>
                		</tr>
                		<tr>
                			<td>compression ratio</td>
                			<td>' . $ratio . '%</td>
                		</tr>
                	</tbody>
                </table>
                </body>
                <script>document.getElementById("minify-name").select();</script>
                </html>';
        
        echo $msg;
        exit();
    }
}

if (! function_exists('string_size'))
{

    function string_size($string)
    {
        if (function_exists('mb_strlen'))
        {
            $size = mb_strlen($string, '8bit');
        }
        else
        {
            $size = strlen($string);
        }
        
        return $size;
    }
}
?>