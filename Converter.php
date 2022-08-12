<?php

/**
 * Класс для разных преобразований
 */

class Converter {

    /**
     * Получает элемент из массива $data
     * $field - Может быть:
     *   - строкой - Возвращает элемент массива
     *   - Массивом - Возвращает элемент вложенного массива, по пути строк во входящем массиве
     *   - функцией - выполняется функция принимая на вход $data и $default
     * $default - Значение по умолчанию (не найден элемент массива).
     */

    static function getValue($data, $field, $default=null) {
        if($field instanceof Closure) {
            return $field($data, $default);
        } elseif(is_array($field) && is_array($data)) {
			$v = array_shift($field);
			$data = self::getValue($data, $v, $default);
			if(count($field)>0){
				return self::getValue($data, $field, $default);
			}else
				return $data;
		} elseif(is_array($data) && array_key_exists($field, $data)) {
			return $data[$field];
		}
		return $default;
    }

}