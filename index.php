<?php

// массив данных: ФИО работника, профессия
$example_persons_array = [ 
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];

// функция getFullnameFromParts принимает как аргумент три строки — фамилию, имя и отчество. 
// Возвращает как результат их же, но склеенные через пробел.
// Пример: как аргументы принимаются три строки «Иванов», «Иван» и «Иванович», а возвращается одна строка — «Иванов Иван Иванович».
function getFullnameFromParts($surname, $name, $patronomyc){
    $fullname = [$surname, $name, $patronomyc];
    $fullnameImplode = implode(' ', $fullname);
    return $fullnameImplode;
}
// echo getFullnameFromParts("Иванов", "Иван", "Иванович"), "\n";

 
// функция getPartsFromFullname принимает как аргумент одну строку — склеенное ФИО. Возвращает как результат массив из трёх элементов с ключами ‘name’, ‘surname’ и ‘patronomyc’.
// Пример: как аргумент принимается строка «Иванов Иван Иванович», а возвращается массив [‘surname’ => ‘Иванов’ ,‘name’ => ‘Иван’, ‘patronomyc’ => ‘Иванович’].
// Обратите внимание на порядок «Фамилия Имя Отчество», его требуется соблюсти.
function getPartsFromFullname($fullName){
    $fullnameExplode = explode(" ",$fullName);
    $fullnameArray = [
        'surname' => $fullnameExplode[0],
        'name' => $fullnameExplode[1],
        'patronomyc' => $fullnameExplode[2],
    ] ;
    return $fullnameArray;
}
// print_r (getPartsFromFullname("Иванов Иван Иванович"));


// функция getShortName, принимает как аргумент строку, содержащую ФИО вида «Иванов Иван Иванович» 
// и возвращает строку вида «Иван И.», где сокращается фамилия и отбрасывается отчество. 
// Для разбиения строки на составляющие использовать функцию getPartsFromFullname.
function getShortName($fullName){
    $split = getPartsFromFullname($fullName);
    $shortName = $split["name"].' '.mb_substr($split["surname"],0,1).".";
    return $shortName;
}
// echo getShortName("Иванов Иван Иванович"), "\n";


// функция getGenderFromName, принимает как аргумент строку, содержащую ФИО (вида «Иванов Иван Иванович»). 
// внутри функции делим ФИО на составляющие с помощью функции getPartsFromFullname;
// изначально «суммарный признак пола» считаем равным 0;
// если присутствует признак мужского пола +1, если женского пола -1.
// после проверок всех признаков, если «суммарный признак пола» больше нуля — возвращаем 1 (мужчина), меньше нуля — возвращаем -1 (женщина); равен 0 — возвращаем 0 (неопределенный пол).
// Признаки женского пола: отчество заканчивается на «вна»; имя заканчивается на «а»; фамилия заканчивается на «ва»;
// Признаки мужского пола: отчество заканчивается на «ич»; имя заканчивается на «й» или «н»; фамилия заканчивается на «в».

function getGenderFromName($fullName){
    $split = getPartsFromFullname($fullName);
    $gender = 0;

    // отчетство
    if (mb_substr($split["patronomyc"],-3,3) == "вна"){
        $gender = -1;
    } elseif (mb_substr($split["patronomyc"],-2,2) == "ич"){
        $gender = 1;
    } else {
        $gender = 0;
    }

    //имя
    $genderName = mb_substr($split["name"],-1,1);

    if ($genderName == "a"){
        $gender = -1;
    } elseif ($genderName == "й" || $genderName == "н"){
        $gender = 1;
    } else {
        $gender = 0;
    }
    
    // фамилия
     if (mb_substr($split["surname"],-2,2) == "ва"){
        $gender = -1;
    } elseif (mb_substr($split["surname"],-1,1) == "в"){
        $gender = 1;
    } else {
        $gender = 0;
    }
    
    // пол
    if (($gender <=> 0) === 1){
        return "мужчина";
    } elseif (($gender <=> 0) === -1){
        return "женщина";
    } else {
        return "неопределенный пол";
    }
}
// echo "аль-Хорезми Мухаммад ибн-Муса - ", getGenderFromName("аль-Хорезми Мухаммад ибн-Муса"), "\n";
// echo "Степанова Наталья Степановна - ", getGenderFromName("Степанова Наталья Степановна"), "\n";
// echo "Иванов Иван Иванович - " , getGenderFromName("Иванов Иван Иванович"), "\n";


// функция getGenderDescription определяет половой состава аудитории. 
// Как аргумент в функцию передается массив, схожий по структуре с массивом $example_persons_array. 
// Как результат функции возвращается информация в следующем виде:
// Гендерный состав аудитории:
// ---------------------------
// Мужчины - 55.5%
// Женщины - 35.5%
// Не удалось определить - 10.0%
// Используйте для решения функцию фильтрации элементов массива, функцию подсчета элементов массива, функцию getGenderFromName, округление.

function getGenderDescription($array){
    
    $male = array_filter($array, function($array) {
        return (getGenderFromName($array['fullname']) == "male");
    });
    $female = array_filter($array, function($array) {
        return (getGenderFromName($array['fullname']) == "female");
    });
    $undefined = array_filter($array, function($array) {
        return (getGenderFromName($array['fullname']) == "undefined");
    });

    $quantity = count($male) + count($female) + count($undefined);
    $malePercent =  round(count($male) / $quantity * 100,2);
    $femalePercent = round(count($female) / $quantity * 100,2);
    $undefinedPercent = round(count($undefined) / $quantity  * 100,2);

    echo "Гендерный состав аудитории:", "\n";
    echo "---------------------------", "\n";
    echo "Мужчины - $malePercent%","\n";
    echo "Женщины - $femalePercent%", "\n";
    echo "Не удалось определить - $undefinedPercent%";
}
// echo getGenderDescription($example_persons_array),"\n";


// функция getPerfectPartner определяет «идеальную» пару. 
// Как первые три аргумента в функцию передаются строки с фамилией, именем и отчеством (именно в этом порядке). 
// При этом регистр может быть любым: ИВАНОВ ИВАН ИВАНОВИЧ, ИваНов Иван иванович.
// Как четвертый аргумент в функцию передается массив, схожий по структуре с массивом $example_persons_array.
// Алгоритм поиска идеальной пары:
// 1.привести фамилию, имя, отчество (переданных первыми тремя аргументами) к привычному регистру;
// 2.склеить ФИО, используя функцию getFullnameFromParts;
// 3.определить пол для ФИО с помощью функции getGenderFromName;
// 4.случайным образом выбрать любого человека в массиве;
// 5.проверить с помощью getGenderFromName, что выбранное из Массива ФИО - противоположного пола, если нет, то возвращаемся к шагу 4, если да - возвращаем информацию.
// 6.Как результат функция возвращает информацию в следующем виде:
// Иван И. + Наталья С. = 
// ♡ Идеально на 64.43% ♡
// Процент совместимости «Идеально на ...» — случайное число от 50% до 100% с точностью два знака после запятой.

function getPerfectPartner($surname, $name, $patronomyc, $array){

    $surname = mb_convert_case(mb_substr($surname, 0, 1), MB_CASE_UPPER, "UTF-8").mb_convert_case(mb_substr($surname, 1, mb_strlen($surname) -1 ), MB_CASE_LOWER, "UTF-8");
    $name = mb_convert_case(mb_substr($name, 0, 1), MB_CASE_UPPER, "UTF-8").mb_convert_case(mb_substr($name, 1, mb_strlen($name) -1 ), MB_CASE_LOWER, "UTF-8");
    $patronomyc = mb_convert_case(mb_substr($patronomyc, 0, 1), MB_CASE_UPPER, "UTF-8").mb_convert_case(mb_substr($patronomyc, 1, mb_strlen($patronomyc) -1 ), MB_CASE_LOWER, "UTF-8");
    $firstPerson = getFullnameFromParts($surname, $name, $patronomyc);
    $firstGender = getGenderFromName($firstPerson); 
    $shortFirstPerson = getShortName($firstPerson);
    $percent = rand(50,100)+rand(0,99)/100;
    
    $secondPerson = $array[rand(0,count($array)-1)]["fullname"];
    $secondGender = getGenderFromName($secondPerson);
    
    if ($firstGender != $secondGender){
        $shortSecondPerson = getShortName($secondPerson);
        echo "$shortFirstPerson + $shortSecondPerson =", "\n";
        echo "♡ Идеально на $percent% ♡";
    } else {
        echo "Пара не найдена, обновите страницу";
    }
}
// print_r(getPerfectPartner("ИвАнОВ", "ИВАн", "иВАновИч", $example_persons_array));