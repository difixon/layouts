<? if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if ( empty($arResult['ITEMS']) ):?>
	<?=GetMessage('MFL_FEEDBACKS_EMPTY_LIST');?>
<?else:?>
	<section class="container bg-feedback">
	
			<div class="row">
				<div class="col-md-6 m-b-30">
				    <div class="clear"></div>
					<div class="slider-carousel feedbacks-slider" data-lightbox-type="gallery">

					<?foreach ($arResult['ITEMS'] as $arItem):?>
						<div class="owl-item">
							<p class="gb-serv"><?=$arItem['NAME'];?></p>
								<p class="gb-comment"><?=$arItem['PREVIEW_TEXT'];?></p>
								<p class="gb-writer"><?=GetMessage('MFL_FEEDBACK_AUTHOR_PREFIX');?> 
								
								<?if (!empty($arItem['PROPERTIES']['ATTR_USER_NAME']['VALUE'])) :?>
									<cite><?=$arItem['PROPERTIES']['ATTR_USER_NAME']['VALUE'];?></cite>
								<?else:?>
									<cite><?=GetMessage('MFL_FEEDBACK_AUTHOR_WO_NAME', array('#USER_ID#' => $arItem['PROPERTIES']['ATTR_USER_ID']['VALUE']));?></cite>
								<?endif;?>
								
								</p>
								<div class="pull-right">
                                    <button class="red-btn" <?if ($USER->IsAuthorized()) :?>
                                        data-target="#MegatronFeedbackFormModal" data-toggle="modal" 
                                    <?else:?>
                                        data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage('MFL_NEED_AUTH_TOOLTIP_TEXT');?>"
                                    <?endif;?>
                                        href="javascript:void()"
                                    ><?=$arParams['BTN_TEXT'];?></button>
                                </div>
								
								
						</div>
					<?endforeach;?>
	
					</div>
				</div>
				<div class="col-md-6 p-l-40 p-r-40" data-animation="fadeInRight">
					<h2 class="gb-q">есть сомнения?</h2>
                    <p class="gb-comment">Залог нашего успеха – довольные клиенты! <br />Почитайте их отзывы на независимых сайтах</p>
					<a class="gb-com-link" href="#"><img src="<?=SITE_TEMPLATE_PATH;?>/assets/img/comms/otzovik.png" alt=""></a>
                    <a class="gb-com-link" href="#"><img src="<?=SITE_TEMPLATE_PATH;?>/assets/img/comms/recommend.png" alt=""></a>
				</div>
			</div>
		
	<?if ($USER->IsAuthorized()) :?>
		<div class="modal fade" id="MegatronFeedbackFormModal" tabindex="-1" role="modal" aria-labelledby="MegatronFeedbackModal-label" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
						<h4 id="MegatronFeedbackModal-label" class="modal-title"><?=GetMessage('MFL_MODAL_TITLE');?></h4>
					</div>
					<div class="modal-body">
						<div class="row mb20">
							<div class="col-sm-12">
								<form action="<?=$_SERVER['SCRIPT_URL'];?>" method="post">
									<input type="text" class="form-control field4bts" name="FIELD4BTS">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="upper" for="feedback_form_name"><?=GetMessage('MFL_FORM_NAME_LABEL');?></label>
												<input id="feedback_form_name" type="text" class="form-control required" name="FEEDBACK_NAME" value="<?=$USER->GetFirstName();?>" aria-required="true" required disabled />
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="upper" for="feedback_form_email"><?=GetMessage('MFL_FORM_EMAIL_LABEL');?></label>
												<input id="feedback_form_email" type="email" class="form-control required email" name="FEEDBACK_EMAIL" value="<?=$USER->GetEmail();?>" aria-required="true" required disabled />
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="upper" for="feedback_form_title"><?=GetMessage('MFL_FORM_TITLE_NAME');?></label>
												<input id="feedback_form_title" type="text" class="form-control required" name="FEEDBACK_TITLE" value="<?=$_POST['FEEDBACK_TITLE'];?>" placeholder="<?=GetMessage('MFL_FORM_TITLE_PLACEHOLDER');?>" aria-required="true" required />
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="upper" for="feedback_form_message"><?=GetMessage('MFL_FORM_TEXT_NAME');?></label>
												<textarea id="feedback_form_message" class="form-control required" name="FEEDBACK_MESSAGE" rows="9" placeholder="<?=GetMessage('MFL_FORM_TEXT_PLACEHOLDER');?>" aria-required="true" required><?=$_POST['FEEDBACK_MESSAGE'];?></textarea>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group text-right">
												<button class="button color button-3d rounded effect text-dark" type="submit"><i class="fa fa-paper-plane"></i> <?=GetMessage('MFL_FORM_SUBMIT_BTN_TEXT');?></button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?endif;?>
	</section>
<?endif;?>