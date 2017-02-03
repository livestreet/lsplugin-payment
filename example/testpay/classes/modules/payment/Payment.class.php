<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/

/**
 * Переопределяем необходимые методы для осуществления платежей
 *
 */
class PluginTestpay_ModulePayment extends PluginTestpay_Inherit_PluginPayment_ModulePayment
{

    /**
     * Инизиализация модуля
     */
    public function Init()
    {
        parent::Init();
        /**
         * Добавляем новый тип объекта для платежей
         */
        $this->AddTargetType('bublik');
    }

    /**
     * Метод проверяет валидность объекта платежа
     *
     * @param int $iTargetId ID объекта платежа
     * @param int $iCheckType Тип проверки объекта, указывает на какой стадии проверяется объект, значение констант PluginPayment_ModulePayment::PAYMENT_TARGET_CHECK_*
     *
     * @return bool    Если валиден возвращаем TRUE, иначе FALSE
     */
    public function CheckTargetBublik($iTargetId, $iCheckType)
    {
        /**
         * У нас все бублики правильные и валидные
         */
        return true;
    }

    /**
     * Проверка прав на оплату счета, если метода нет, то считаем платеж разрешенным.
     * Например, в этом методе можно проверять авторизован ли пользователь и разрешать покупку только авторизованным.
     *
     * @param unknown_type $oPayment
     * @param unknown_type $oTarget
     *
     * @return bool
     */
    public function CheckAccessForPaymentTargetBublik($oPayment, $oTarget)
    {
        /**
         * Разрешаем платежи всем
         */
        return true;
    }

    /**
     * Возвращет информации об объекте покупки
     *
     * @param int $iTargetId ID объекта платежа
     *
     * @return array    Поддерживаются поля: name - название объекта платежа (отображается на странице оформления платежа), payment_description - описание платежа для платежной системы
     */
    public function GetTargetInfoBublik($iTargetId)
    {
        return array('name' => "Бублик номер {$iTargetId}", 'payment_description' => "Оплата бублика номер {$iTargetId}");
    }

    /**
     * Платеж завершился успешно.
     * Именно в этом методе необходимо вызывать логики по оработке платежа!
     *
     * @param unknown_type $oPayment
     * @param unknown_type $oTarget
     */
    public function MakePaymentSuccessTargetBublik($oPayment, $oTarget)
    {
        /**
         * Реализация вашей логики после совершения пользователем оплаты
         * Факт оплаты подтверждается только в этом методе!
         */
    }

    /**
     * Информирование об успешности платежа в момент редиректа пользователя обратно на сайт.
     * В этом методе реализовывать логику по обработке платежа НЕ нужно, т.к. он может вообще не отрабоать (например, пользователь не стал переходит обратно на сайт после платежа)
     * Здесь вы можете сделать редирект на свою страницу информирующую об успешности платежа и каких то дальнейших действиях
     * По умолчанию показывается стандартная страница с информацией об успешном платеже
     *
     * @param unknown_type $oPayment
     * @param unknown_type $oTarget
     */
    public function ProcessPaymentSuccessTargetBublik($oPayment, $oTarget)
    {

    }

    /**
     * Информирование о несостоявшемся платеже в момент редиректа пользователя обратно на сайт.
     * Здесь вы можете сделать редирект на свою страницу информирующую о несостоявшемся платеже и каких то дальнейших действиях
     * По умолчанию показывается стандартная страница с ошибкой платежа
     *
     * @param unknown_type $oPayment
     * @param unknown_type $oTarget
     */
    public function ProcessPaymentFailTargetBublik($oPayment, $oTarget)
    {

    }
}