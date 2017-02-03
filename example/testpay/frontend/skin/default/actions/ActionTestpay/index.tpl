{extends file='layouts/layout.base.tpl'}

{block name='layout_content'}

    <h2>Создание платежа на примере оплаты бубликов</h2>

    {if $aPaymentTargets}
        Вы уже оплатили бублики:
        <br>
        {foreach from=$aPaymentTargets item=oPaymentTarget}
            бублик номер {$oPaymentTarget->getTargetId()}
            <br>
        {/foreach}
        <br>
    {/if}

    <form action="" method="post">
        {component 'field' template='hidden.security-key'}

        {component 'field' template='select'
            name          = 'bublik_number'
            label         = 'Какой из бубликов вы хотите купить'
            inputClasses  = 'ls-width-200'
            selectedValue = $_aRequest.bublik_number
            items         = [
                [ 'value' => '1', 'text' => '1' ],
                [ 'value' => '2', 'text' => '2' ],
                [ 'value' => '3', 'text' => '3' ],
                [ 'value' => '4', 'text' => '4' ],
                [ 'value' => '5', 'text' => '5' ],
                [ 'value' => '6', 'text' => '6' ]
            ]}

        {component 'field' template='text'
            name    = 'bublik_sum'
            inputClasses  = 'ls-width-200'
            rules   = [ 'required' => true ]
            label   = 'Сколько готовы за него заплатить'}

        {component 'button' name='submit_buy' mods='primary' text='Купить'}
    </form>

{/block}