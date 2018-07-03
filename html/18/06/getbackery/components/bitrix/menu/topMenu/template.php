<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arServiceCurrency = CMegatronTools::GetServiceCurrency();
?>

<div class="navbar-collapse collapse main-menu-collapse navigation-wrap">
	<div class="container">
		<nav id="mainMenu" class="main-menu mega-menu">
		
		<?if (!empty($arResult)):?>
			<ul class="main-menu nav nav-pills">
				

			<?foreach($arResult as $arItem):
				if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
					continue;
			?>
				
				<li><a href="<?=$arItem['LINK'];?>"><?=$arItem['TEXT'];?></a></li>
					
			<?endforeach?>
				
			<?if ($USER->IsAuthorized()):
				$oUser = new CMegatronUser();
				$arBalance = $oUser->GetBalance();
			?>
				
				<li class="dropdown highlight highlight-colored text-center text-uppercase" style="border-radius: 0">
					<a class="<?=$GLOBALS['MEGATRON']['SETTINGS']['COLOR_SCHEME_TEXT_COLOR']?>" href="/cabinet/">
						<?if (0 < strlen($USER->GetFirstName())) :?>
							<?=$USER->GetFirstName()?>
						<?else:?>
							<?=$USER->GetLogin()?>
						<?endif;?>
					<?if ('1' != $oUser->arUser['UF_VIP_ACCOUNT']) :?>
						<?if ($userAccountLevel = $oUser->GetAccountLevel()):?>
							<sup class="text-center text-uppercase <?=$GLOBALS['MEGATRON']['SETTINGS']['COLOR_SCHEME_TEXT_COLOR']?>"><?=$userAccountLevel['LEVEL_NAME']?></sup>
						<?endif;?>
					<?else:?>
						<sup class="text-center text-uppercase <?=$GLOBALS['MEGATRON']['SETTINGS']['COLOR_SCHEME_TEXT_COLOR']?>">VIP</sup>
					<?endif;?>
					
						<span class="font-weight-400" style="font-size: 13px;">
							&nbsp;|&nbsp;&nbsp;<span class=""><?=$arServiceCurrency['HTML_ICON']?></span> <?=$arBalance['MAIN'] + $arBalance['PENDING']?>
						</span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a class="text-dark" href="<?=SITE_DIR;?>cabinet/orders" style="background-color: #fff">
								<i class="fa fa-list fa-fw"></i> <?=GetMessage('CAB_LINK_ORDERS_TEXT');?>
							</a>
						</li>
						<li>
							<a class="text-dark" href="<?=SITE_DIR;?>cabinet/payouts" style="background-color: #fff">
								<i class="fa fa-reply fa-fw"></i> <?=GetMessage('CAB_LINK_PAYOUTS_TEXT');?>
							</a>
						</li>
						<li>
							<a class="text-dark" href="<?=SITE_DIR;?>cabinet/referals" style="background-color: #fff">
								<i class="fa fa-users fa-fw"></i> <?=GetMessage('CAB_LINK_REFERALS_TEXT');?>
							</a>
						</li>
						<li>
							<a class="text-dark" href="<?=SITE_DIR;?>cabinet/profile" style="background-color: #fff">
								<i class="fa fa-user fa-fw"></i> <?=GetMessage('CAB_LINK_PROFILE_TEXT');?>
							</a>
						</li>
						<li>
							<a class="text-dark" href="<?=SITE_DIR;?>cabinet/support" style="background-color: #fff">
								<i class="fa fa-support fa-fw"></i> <?=GetMessage('CAB_LINK_SUPPORT_TEXT');?>
							</a>
						</li>
					</ul>
				</li>
				<li class="text-center">
					<a class="text-red" href="<?=SITE_DIR;?>?logout=yes"><?=GetMessage('LOGOUT_LINK_TEXT');?></a>
				</li>
			<?else:?>
				<li class="highlight highlight-colored text-center text-uppercase <?=$GLOBALS['MEGATRON']['SETTINGS']['COLOR_SCHEME_TEXT_COLOR']?>" style="border-radius: 0"><a href="/cabinet/"><?=GetMessage('CAB_LINK_TEXT');?></a></li>
			<?endif;?>

			</ul>
		<?endif?>
		
		</nav>
	</div>
</div> 