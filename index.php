<?php

/**
 * Configuration
 */
$base_directory   = './';

/**
 * FUNCTIONS
 */
function createModules($files)
{
  $file_data = $files;
  foreach ($file_data as $item => $data)
  {
    $name            = $data['name'];
    $path            = $data['path'] . "/";
    $module_filename = $data['module_filename'];
    $module_name     = $data['module_name'];
    $component_name  = $data['component_name'];
    
    $module_fullpath = $path . $module_filename;
    $module_content  = GetModuleCode($name, $component_name, $module_name);
    
    if (file_put_contents($module_fullpath, $module_content) !== false)
    {
      echo '<span>File created (' . basename($module_fullpath) . ')</span><br>';
    }
    else
    {
      echo '<span class="error">Error creating file (' . basename($module_fullpath) . ')</span><br>';
    }
  }
}
function GetModuleCode($name, $component_name, $module_name)
{
  $component_fullpath = str_replace('.ts', '', $name);
  $module_code        = <<<EOT
import { NgModule } from '@angular/core'; 
import { CommonModule } from '@angular/common' 
import { $component_name } from './$component_fullpath'

@NgModule({
  imports: [ CommonModule ], 
  declarations: [ $component_name ], 
  exports: [ $component_name ] 
}) 

export class $module_name { };
EOT;
  return $module_code;
}

function GetFileData($files)
{
  for ($i = 0; $i < count($files); $i++)
  {
    $fullpath        = $files[$i];
    $path_end        = strripos($fullpath, '/');
    $path            = substr($fullpath, 0, $path_end);
    $name_start      = $path_end + 1;
    $name_end        = abs(strlen($fullpath) - $start);
    $name            = substr($fullpath, $name_start, $name_end);
    $clean_name      = kebabToCamel(explode('.', $name)[0]);
    $module_filename = str_replace('component', 'module', $name);
    if (strpos($name, 'component.ts') == true)
    {
      $filenames[] = array(
        'name' => $name,
        'path' => $path,
        'module_filename' => $module_filename,
        'module_name' => $clean_name . 'Module',
        'component_name' => $clean_name . 'Component'
      );
    }
  }
  return $filenames;
}

function GetFilesFromDirectory($base_directory)
{
  $allowed_extensions = array('.ts');
  $string_to_find    = 'component';
  $ob = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base_directory), RecursiveIteratorIterator::SELF_FIRST);
  foreach ($ob as $name => $object):
    if (is_file($name))
    {
      foreach ($allowed_extensions as $k => $ext):
        if (substr($name, (strlen($ext) * -1)) == $ext)
        {
          $tmp = file_get_contents($name);
          if (strpos($tmp, $string_to_find) !== false)
            $files[] = $name;
        }
      endforeach;
    }
  endforeach;
  return $files;
}

function kebabToCamel($string) { return str_replace('-', '', ucwords($string, '-')); }
function FilterFiles($string) { return strpos($string, 'spec') === false; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Auto Modules</title>
</head>
<body>
  <style>*{box-sizing:border-box}body{font-family:monospace;line-height:1.62;background:#ccc}div.output{text-align:left;background:#000;margin:50px auto;overflow-x:hidden;overflow-y:scroll;width:600px;height:350px;padding:20px}span{color:#4bb543}span.error{color:#c00}form{display:block;text-align:center;width:100%;height:100vh}input[type=submit]{background-color:#4caf50;border:none;color:#fff;font-size:16px;padding:16px 32px;text-decoration:none;cursor:pointer;position:relative;top:25%}</style> 

<?php if (isset($_POST['go'])): ?>
  <div class="output">
    <?php
      $allFiles = GetFilesFromDirectory($base_directory);
      $files = GetFileData($allFiles);
      createModules($files); 
    ?>
  </div>
<?php else: ?>
  <form action="" method="post">
    <input type="submit" name="go" value="Generate Modules">
  </form>
<?php endif;?>
</body>
</html>