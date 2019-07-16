<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require_once 'vendor/autoload.php';

$log = new Logger('beecool-rename');
$log->pushHandler(new StreamHandler('logs/rename.log', Logger::INFO));

$path = './';

// $filename = $path .'CEL/Power Bank com display - CEL022- Beecool.jpg 2.jpg';
// $pattern = '/[A-Z]{3}[ ]?[0-9]{3}/i';
// preg_match($pattern, $filename, $m);

// if (!empty($m)) {
//     $ext = substr($filename, -3);
//     $newname = str_replace(' ', '', $m[0]) .'.'. $ext;
//     var_dump(rename($filename, $newname));
//     exit;
// }
// echo "Erro";

$log->info('Iniciando o log da aplicaccao');

$folders = ['CEL', 'ECO', 'SPA', 'TEC', 'VIP', 'WOW'];
foreach ($folders as $folder) {
    $log->info('Lendo pasta', ['folder' => $folder]);

    if ($handle = opendir($path . $folder)) {

        while (false !== ($filename = readdir($handle))) {

            $ext = substr($filename, -3);
            $log->info('Extensao do arquivo', ['arquivo' => $filename, 'ext' => $ext]);
    
            if (in_array($ext, ['jpg', 'gif', 'png'])) {
                $pattern = '/[A-Z]{3}[ ]?[0-9]{3}/i';
                preg_match($pattern, $filename, $m);
    
                $log->info('retorno da checagem do codigo', $m);
    
                if (!empty($m)) {
                    $newname = str_replace(' ', '', $m[0]) .'.'. $ext;
                    $log->info('Novo nome do arquivo', [$newname]);
                    
                    if (rename($folder .'/'. $filename, $path . $newname)) {
                        $log->info('arquivo gerado com sucesso!');
                    } else {
                        $log->error('erro ao renomear o arquivo');
                    }
                } else {
                    $log->warning('Não foi encontrado resultado para regex');
                }
            }
    
        }

    }
}
$log->info('Fim da execucao');

// if ($handle = opendir($path . $folder)) {
//     while (false !== ($filename = readdir($handle))) {

//         if (is_file($filename)) {
//             echo "Nome atual: {$filename}\n";
//             $ext = substr($filename, -3);
            
//             $pattern = '/[A-Z]{3}[ ]?[0-9]{3}/i';
//             preg_match($pattern, $filename, $m);
            
//             if (!empty($m)) {
//                 $newname = str_replace(' ', '', $m[0]) .'.'. $ext;
//                 echo "Novo nome: {$newname}\n";
//                 rename($filename, $newname);
//             } else {
//                 echo "Arquivo: {$filename} não tem codigo.\n";
//             }
//         }
//     }
//     closedir($handle);
// }