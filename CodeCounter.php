<?php

function FilesReader($folder, $ext)
{

    if (!$dir = opendir($folder))
        echo "something wrong";


    while ($file = readdir($dir)) {


        if (is_file($folder . "/" . $file)) {  //без полного пути работать is_file и is_dir не будет во вложенных папках относительно скрипта.
            echo "<pre>";

            $file_ext = pathinfo($file, PATHINFO_EXTENSION); //Получаем информацию о расширении файла.
            if ($ext == $file_ext) { //Проверяем расширение на соответствие с принятым функцией.


                $filecount = count(file($folder . "/" . $file)); //считаем количество файлов в папке
                $lines[$folder . "/" . $file] = $filecount;
            } //пихаем циферки в массив, с названиями файлов.

        } elseif ($file !== '.' && $file !== '..' && is_dir($folder . "/" . $file)) { //Проверяем, чтобы файл был директорией,
// и чтобы он не был текущей и директорией сверху, иначе все зациклится на них. Т.е. открыв текущую директорию,
// в следующей итерации цикл опять ее увидит и откроет.

            FilesReader($folder . "/" . $file, $ext); //Вызываем саму себя
        }

    }

    closedir();

    print_r($lines); //печатаем массив с названиями файлов и количеством строк кода.

}


FilesReader("./", "txt");



