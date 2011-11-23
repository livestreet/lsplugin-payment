{assign var="noSidebar" value=true}
{include file='header.tpl'}

	<div class="topic">
		<div class="content">
			<h2>Ошибка при выполнении платежа</h2>
			
			
			{if $oPayment}
				<br/> Номер платежа: <b>{$oPayment->getId()}</b>
			{/if}
		</div>
	</div>
	
{include file='footer.tpl'}