{assign var="noSidebar" value=true}
{include file='header.tpl'}

<h2>Создание платежа на примере оплаты бубликов</h2>

{if $aPaymentTargets}
	Вы уже оплатили бублики: <br>
	{foreach from=$aPaymentTargets item=oPaymentTarget}
		бублик номер {$oPaymentTarget->getTargetId()}<br>
	{/foreach}
	<br>
{/if}

<form action="" method="post">
	<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
	
	Какой из бубликов вы хотите купить: 
	<select name="bublik_number">
		<option>1</option>
		<option>2</option>
		<option>3</option>
		<option>4</option>
		<option>5</option>
		<option>6</option>
	</select><br>
	
	
	Сколько готовы за него заплатить: 	
	<input type="text" name="bublik_sum"><br>
	
	<input type="submit" name="submit_buy" value="Купить">
</form>

{include file='footer.tpl'}