<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Iterator
 *
 * @author Lisun
 */
interface MyIterator {
    public function rewind(); //помещает указатель в начало списка
    public function current();//возвращает элемент находящийся в текущей позиции указателя
    public function key();//возвращает текущий ключ
    public function next();//возвращает элемент в текущей позиции указателя, и перемещаетуказатель на следующую позицию
    public function valid();//подтверждает что существует элемент в текущей позиции указателя
}

interface Observable {
    function attach (Observer $observer);
    function detach (Observer $observer);
    function notify ();
}
