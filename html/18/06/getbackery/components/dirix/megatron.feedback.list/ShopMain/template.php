<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

$isLazyLoad = false;

if ('Y' == $arParams['SHOW_FILTERS'])
{
    $this->addExternalJs(SITE_TEMPLATE_PATH.'/assets/vendor/isotope/jquery.isotope.js');
    $this->addExternalJs(SITE_TEMPLATE_PATH.'/assets/vendor/jquery.lazyload/jquery.lazyload.min.js');

    $isLazyLoad = true;
    $curdirpath = str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__);

    $this->addExternalJs($curdirpath.'/isotope_init.js');
    $this->addExternalJs($curdirpath.'/lazyload_init.js');
}
?>
<div class="container">
<?if ('Y' == $arParams['SHOW_SIDECATS']):?>
	<div class="col-sm-3">
		<ul class="shop-categories">
			<h4 class="text-center"><?=GetMessage('CATS_BLOCK_TITLE');?></h4>
				
			<?foreach ($arResult['FILTER']['CATEGORIES'] as $arCategory) :?>
				<li><a href="<?=$arCategory['DETAIL_PAGE_URL']?>"><?=$arCategory['NAME']?> (<?=$arCategory['OFFERS_CNT']?>)</a></li>
			<?endforeach;?>
		</ul>
	</div>
	<div class="col-sm-9">
<?else:?>
	<div class="col-sm-12" 1>
<?endif;?>

<?if ('Y' == $arParams['SHOW_FILTERS']) :?>
	
	<div class="row shopFilters m-b-30 m-l-0 m-r-0">
		<div class="col-md-4">
			<h4 class="text-center"><?=GetMessage('FILTERS_BY_NAME_TITLE');?></h4>
			<form style="margin:0">
				<input class="form-control" type="text" id="nameFilter" placeholder="<?=GetMessage('FILTERS_BY_NAME_INPUT_PH');?>">
			</form>
		</div>
		<div class="col-md-8" style="border-left: 1px solid rgba(0,0,0,0.1);">
			<h4 class="text-center"><?=GetMessage('FILTERS_BY_PARAMS_TITLE');?> <span id="filterCount"></span></h4>
			<div class="row" id="shopFilters">
			<?if ('Y' != $arParams['SHOW_SIDECATS']):?>
				<div class="col-md-6">
					<select id="catFilter">
						<option class="" value="*"><?=GetMessage('FILTERS_CAT_SELECT_DEFAULT');?></option>

					<?foreach ($arResult['FILTER']['CATEGORIES'] as $arOfferCat) :?>
						<option class="" value=".<?=$arOfferCat['ID']?>"><?=$arOfferCat['NAME']?></option>
					<?endforeach;?>

					</select>
				</div>
			<?endif;?>
			
				<div class="<?if ('Y' != $arParams['SHOW_SIDECATS']):?>col-md-6<?else:?>col-md-12<?endif;?>">
					<select id="rateTypeFilter">
						<option class="list__item filter-li" value="*"><?=GetMessage('FILTERS_TYPE_SELECT_DEFAULT');?></option>
						<option class="list__item filter-li" value=".percentRate">
							<?=GetMessage('FILTERS_TYPE_RATE_PERCENT');?>
						</option>
						<option class="list__item filter-li" value=".fixRate">
							<?=GetMessage('FILTERS_TYPE_RATE_FIX');?>
						</option>
					</select>
				</div>
			</div>
		</div>
	</div>
<?endif;?>
	<div class="shopsList isotope">
	<?if (!empty($arParams['TITLE'])) :?>
		<div class="hr-full center m-b-25">
		<h2 class="header">
           <div class="left-left"></div>
            <?=$arParams['~TITLE']?> <span>всё честно!</span>
           <div class="right-right"></div> 
        </h2>
<!--		<abbr><?//=$arParams['~TITLE']?></abbr>-->
        </div>
	<?endif;?>
	
	<?
	if (0 < $arResult["SECTIONS_COUNT"])
	{
		if ('Y' == $arParams['SHOW_SIDECATS']) 
		{
			$shopBlockWidthClass = 'col-xs-12 col-sm-4 col-md-3';
			
		} else 
		{
			$shopBlockWidthClass = 'col-xs-12 col-sm-4 col-md-2';
		}
		
		foreach ($arResult['SECTIONS'] as $arItem)
		{
			$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
			$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
			
			unset($shopCatsStr);
			
			foreach ($arItem['UF_ADVCAMP_CATS'] as $shopCatID) 
			{
				$shopCatsStr .= $shopCatID.' ';
			}
			
		?>
			<a class="shopBlock <?=$shopBlockWidthClass;?> <?=$shopCatsStr;?><?if('Y' == $arItem['CASHBACK_INFO']['FLAGS']['HAVE_PERCENT_RATES']):?> percentRate<?endif;?><?if('Y' == $arItem['CASHBACK_INFO']['FLAGS']['HAVE_FIXED_RATES']):?> fixRate<?endif;?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>" href="<?=$arItem['SECTION_PAGE_URL'];?>">
				<div class="shopInfo">
				
				<?if ($isLazyLoad) :?>	
					<img class="img-responsive center" src="<?=SITE_TEMPLATE_PATH;?>/assets/images/empty143x59.jpg" data-original="<?=$arItem['PICTURE']['SRC'];?>" alt="<?=$arItem['PICTURE']['ALT'];?>">
				<?else:?>
					<img class="img-responsive center" src="<?=$arItem['PICTURE']['SRC'];?>" alt="<?=$arItem['PICTURE']['ALT'];?>">
				<?endif;?>
				
					<div class="shopName m-t-10 m-b-10 p-l-15 p-r-15 font-weight-600 text-uppercase background-colored text-dark" style="font-size:17px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><?=$arItem['NAME']?></div>
					<div class="m-t-15 text-dark font-weight-300 text-uppercase" style="font-size:17px;"><?=GetMessage('OFFER_BLOCK_CB_RATE_PREFIX');?></div>
					<div class="separator m-t-5 m-b-0 text-dark font-weight-700" style="font-size:15px;">
						<span class="m-l-10 m-r-0">
							<?=$arItem['CASHBACK_INFO']['RATES']['DISPLAY_VALUE'];?>
						</span>
					</div>
					<div class="separator m-t-10 m-b-10 text-dark font-weight-300" style="font-size: 12px;">
                        <span class="m-l-10 m-r-0">
                            <?=GetMessage('OFFER_BLOCK_CB_RATE_POSTFIX');?>
                        </span>
                    </div>
				</div>
			</a>
		<?
		}
	}
	?>
	
	</div>
	
	</div>
</div>