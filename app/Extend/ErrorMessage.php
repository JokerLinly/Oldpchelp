<?php

/**
* 全局错误类 
* @author JokerLinly
*/
class ErrorMessage 
{

    private static $error_valus = array(
        /**用户错误码**/
        '10000' => array(
            'default' => '用户参数错误！',
        ),
        '10001' => array(
            'default' => '用户不存在！',
        ),
    );

    /**
     * 获取错误返回信息
     *
     * @author JokerLinly create 2016-08-27
     * @param  ing         $err_code                        错误代码
     * @param  string     $key                            下标
     * @param  array     $data                            返回数据
     * @return array
     */
    public static function getMessage($err_code, $data = '', $key = 'default')
    {
        $err_text = '';
        $err_num  = 10000;

        if (!isset($err_code)) {
            $err_text = self::$error_valus[$err_num]['param_err'];
            return array("err_msg" => $err_text, "data" => '', "err_code" => $err_num);
        }

        if (isset(self::$error_valus[$err_code]) && $err_code > 0) {

            if (isset(self::$error_valus[$err_code][$key])) {
                $err_text = self::$error_valus[$err_code][$key];
            } else {
                $err_text = self::$error_valus[$err_code]['default'];
            }

            $err_num = $err_code;

        } else {

            if (isset(self::$error_valus[$err_num]['param_err'])) {
                $err_text = self::$error_valus[$err_num]['param_err'];
            }

        }

        return array("err_msg" => $err_text, "data" => $data, "err_code" => $err_num);

    }

    public static function getSuccessMessage($data = array())
    {

        return array('err_msg' => '', 'data' => $data, 'err_code' => 0);
    }
}

