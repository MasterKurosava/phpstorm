<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <!-- Объединение -->
  <?php

$sname='Калачев';//фамилия
    $fname='Михаил';//имя
    $tname='Евгеньевич';//отчество

    echo "$sname $fname $tname";
  ?>
  <br>

  <!-- ФИО -->
  <?php
    $name=explode(' ','Калачев Михаил Евгеньевич');//имя
    $name=array_map(function($el){
      return mb_substr($el ,0,1);
    },$name);
    echo join('.',$name);
  ?>
  <br>
  <!-- Определить пол -->
  <?php
    $name=explode(' ','Калачев Михаил Евгеньевич');//имя
    $male=0;
    //провера на фамилию
    if(mb_substr(mb_strtolower($name[0]),-1)=='в') $male++;
    else if(mb_substr(mb_strtolower($name[0]),-2)=='ва') $male--;
    
    if(mb_substr(mb_strtolower($name[2]),-2)=='ич') $male++;
    else if(mb_substr(mb_strtolower($name[2]),-3)=='вна') $male--;

    echo($male<=-1?'Женский':($male==0?'Не определен':'Мужской'));
  ?>
  <br>
  <!-- Показать состав аудитории -->
  <?php
    require_once './arr.php';
    $users=[
      'sum'=>0,
      'male'=>0,
      'female'=>0,
      'unknown'=>0
    ];
    foreach($arr as $user){
      $user=explode(' ',$user);
      if(mb_substr(mb_strtolower($user[0]),-1)=='в' || mb_substr(mb_strtolower($user[2]),-2)=='ич') $users['male']++;
      else if(mb_substr(mb_strtolower($user[0]),-2)=='ва' || mb_substr(mb_strtolower($user[2]),-3)=='вна') $users['female']++;
      else $users['unknown']++;
      $users['sum']++;
    };
    $statistic=[
      'male'=>round($users['male']/$users['sum']*100, 1),
      'female'=>round($users['female']/$users['sum']*100, 1),
      'unknown'=>round($users['unknown']/$users['sum']*100, 1)
    ];
    echo<<<maleStat
    <br>
    Гендерный состав аудитории:<br>
    __________________________<br>
    Мужчины - {$statistic['male']}%<br>
    Женщины - {$statistic['female']}%<br>
    Неопределено - {$statistic['unknown']}%<br>
maleStat
  ?>

  <br>
  <!-- Найти идеальную пару -->
  <?php
    $name='Калачев Михаил Евгеньевич';//имя

    if(mb_substr(mb_strtolower(explode(' ',$name)[0]),-1)=='в' || mb_substr(mb_strtolower(explode(' ',$name)[2]),-2)=='ич') $male='male';
    else if(mb_substr(mb_strtolower(explode(' ',$name)[0]),-2)=='ва' || mb_substr(mb_strtolower(explode(' ',$name)[2]),-3)=='вна') $male='female';
    else $male='unknown';

    if($male=='female'){
      $people=array_filter($arr, function($el){
        if(mb_substr(mb_strtolower(explode(' ',$el)[0]),-1)=='в' || mb_substr(mb_strtolower(explode(' ',$el)[2]),-2)=='ич') return $el;
      });
    }else{
      $people=array_filter($arr, function($el){
        if(mb_substr(mb_strtolower(explode(' ',$el)[0]),-2)=='ва' || mb_substr(mb_strtolower(explode(' ',$el)[2]),-3)=='вна') return $el;
      });
    }
    $pair=[$name,$people[array_rand($people)]];
    $pair=array_map(function($el){
      $el=explode(' ',$el);
      array_pop($el);
      $el[1]=mb_substr($el[1],0,1).".";
      $el=join(' ',$el);
      print_r($el);
    }, $pair);
    $num=rand(500,1000)/10;

    echo<<<maleStat
    {$pair[0]} {$pair[1]} =
    Идеально на $num%
maleStat
  ?>
</body>
</html>