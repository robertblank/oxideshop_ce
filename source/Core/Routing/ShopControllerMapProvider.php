<?php
/**
 * This file is part of OXID eShop Community Edition.
 *
 * OXID eShop Community Edition is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID eShop Community Edition is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eShop Community Edition.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2017
 * @version   OXID eShop CE
 */
namespace OxidEsales\EshopCommunity\Core\Routing;

use OxidEsales\EshopCommunity\Core\Contract\ControllerMapProviderInterface;

/**
 * This class determines the controllers which should be allowed to be called directly via
 * HTTP GET/POST Parameters, inside form actions or with oxid_include_widget.
 * Those controllers are specified e.g. inside a form action with a controller key which is mapped to its class.
 *
 * @internal Do not make a module extension for this class.
 * @see      http://oxidforge.org/en/core-oxid-eshop-classes-must-not-be-extended.html
 */
class ShopControllerMapProvider implements ControllerMapProviderInterface
{

    private $controllerMap = [
        'language'                             => \OxidEsales\Eshop\Application\Controller\Admin\LanguageController::class,
        'module'                               => \OxidEsales\Eshop\Application\Controller\Admin\ModuleController::class,
        'theme'                                => \OxidEsales\Eshop\Application\Controller\Admin\ThemeController::class,
        'manufacturerlist'                     => \OxidEsales\Eshop\Application\Controller\ManufacturerListController::class,
        'review'                               => \OxidEsales\Eshop\Application\Controller\ReviewController::class,
        'vendorlist'                           => \OxidEsales\Eshop\Application\Controller\VendorListController::class,
        'actions'                              => \OxidEsales\Eshop\Application\Controller\Admin\ActionsController::class,
        'account_user'                         => \OxidEsales\Eshop\Application\Controller\AccountUserController::class,
        'account_wishlist'                     => \OxidEsales\Eshop\Application\Controller\AccountWishlistController::class,
        'vendor_main'                          => \OxidEsales\Eshop\Application\Controller\Admin\VendorMain::class,
        'vendor_main_ajax'                     => \OxidEsales\Eshop\Application\Controller\Admin\VendorMainAjax::class,
        'vendor_seo'                           => \OxidEsales\Eshop\Application\Controller\Admin\VendorSeo::class,
        'voucherserie'                         => \OxidEsales\Eshop\Application\Controller\Admin\VoucherSerieController::class,
        'voucherserie_export'                  => \OxidEsales\Eshop\Application\Controller\Admin\VoucherSerieExport::class,
        'voucherserie_generate'                => \OxidEsales\Eshop\Application\Controller\Admin\VoucherSerieGenerate::class,
        'voucherserie_groups'                  => \OxidEsales\Eshop\Application\Controller\Admin\VoucherSerieGroups::class,
        'voucherserie_groups_ajax'             => \OxidEsales\Eshop\Application\Controller\Admin\VoucherSerieGroupsAjax::class,
        'voucherserie_list'                    => \OxidEsales\Eshop\Application\Controller\Admin\VoucherSerieList::class,
        'voucherserie_main'                    => \OxidEsales\Eshop\Application\Controller\Admin\VoucherSerieMain::class,
        'wrapping_list'                        => \OxidEsales\Eshop\Application\Controller\Admin\WrappingList::class,
        'wrapping_main'                        => \OxidEsales\Eshop\Application\Controller\Admin\WrappingMain::class,
        'dynscreen'                            => \OxidEsales\Eshop\Application\Controller\Admin\DynamicScreenController::class,
        'dynscreen_list'                       => \OxidEsales\Eshop\Application\Controller\Admin\DynamicScreenList::class,
        'dynscreen_local'                      => \OxidEsales\Eshop\Application\Controller\Admin\DynamicScreenLocal::class,
        'genexport'                            => \OxidEsales\Eshop\Application\Controller\Admin\GenericExport::class,
        'genexport_do'                         => \OxidEsales\Eshop\Application\Controller\Admin\GenericExportDo::class,
        'genexport_main'                       => \OxidEsales\Eshop\Application\Controller\Admin\GenericExportMain::class,
        'genimport'                            => \OxidEsales\Eshop\Application\Controller\Admin\GenericImport::class,
        'language_list'                        => \OxidEsales\Eshop\Application\Controller\Admin\LanguageList::class,
        'language_main'                        => \OxidEsales\Eshop\Application\Controller\Admin\LanguageMain::class,
        'list_review'                          => \OxidEsales\Eshop\Application\Controller\Admin\ListReview::class,
        'list_user'                            => \OxidEsales\Eshop\Application\Controller\Admin\ListUser::class,
        'login'                                => \OxidEsales\Eshop\Application\Controller\Admin\LoginController::class,
        'manufacturer'                         => \OxidEsales\Eshop\Application\Controller\Admin\ManufacturerController::class,
        'manufacturer_list'                    => \OxidEsales\Eshop\Application\Controller\Admin\ManufacturerList::class,
        'manufacturer_main'                    => \OxidEsales\Eshop\Application\Controller\Admin\ManufacturerMain::class,
        'manufacturer_main_ajax'               => \OxidEsales\Eshop\Application\Controller\Admin\ManufacturerMainAjax::class,
        'manufacturer_seo'                     => \OxidEsales\Eshop\Application\Controller\Admin\ManufacturerSeo::class,
        'module_config'                        => \OxidEsales\Eshop\Application\Controller\Admin\ModuleConfiguration::class,
        'module_list'                          => \OxidEsales\Eshop\Application\Controller\Admin\ModuleList::class,
        'module_main'                          => \OxidEsales\Eshop\Application\Controller\Admin\ModuleMain::class,
        'module_sortlist'                      => \OxidEsales\Eshop\Application\Controller\Admin\ModuleSortList::class,
        'navigation'                           => \OxidEsales\Eshop\Application\Controller\Admin\NavigationController::class,
        'news_list'                            => \OxidEsales\Eshop\Application\Controller\Admin\NewsList::class,
        'news_main'                            => \OxidEsales\Eshop\Application\Controller\Admin\NewsMain::class,
        'news_main_ajax'                       => \OxidEsales\Eshop\Application\Controller\Admin\NewsMainAjax::class,
        'news_text'                            => \OxidEsales\Eshop\Application\Controller\Admin\NewsText::class,
        'newsletter_list'                      => \OxidEsales\Eshop\Application\Controller\Admin\NewsletterList::class,
        'newsletter_main'                      => \OxidEsales\Eshop\Application\Controller\Admin\NewsletterMain::class,
        'newsletter_plain'                     => \OxidEsales\Eshop\Application\Controller\Admin\NewsletterPlain::class,
        'newsletter_preview'                   => \OxidEsales\Eshop\Application\Controller\Admin\NewsletterPreview::class,
        'newsletter_selection'                 => \OxidEsales\Eshop\Application\Controller\Admin\NewsletterSelection::class,
        'newsletter_selection_ajax'            => \OxidEsales\Eshop\Application\Controller\Admin\NewsletterSelectionAjax::class,
        'newsletter_send'                      => \OxidEsales\Eshop\Application\Controller\Admin\NewsletterSend::class,
        'order_address'                        => \OxidEsales\Eshop\Application\Controller\Admin\OrderAddress::class,
        'order_article'                        => \OxidEsales\Eshop\Application\Controller\Admin\OrderArticle::class,
        'order_downloads'                      => \OxidEsales\Eshop\Application\Controller\Admin\OrderDownloads::class,
        'order_main'                           => \OxidEsales\Eshop\Application\Controller\Admin\OrderMain::class,
        'order_overview'                       => \OxidEsales\Eshop\Application\Controller\Admin\OrderOverview::class,
        'order_remark'                         => \OxidEsales\Eshop\Application\Controller\Admin\OrderRemark::class,
        'oxnavigationtree'                     => \OxidEsales\Eshop\Application\Controller\Admin\NavigationTree::class,
        'payment_country'                      => \OxidEsales\Eshop\Application\Controller\Admin\PaymentCountry::class,
        'payment_country_ajax'                 => \OxidEsales\Eshop\Application\Controller\Admin\PaymentCountryAjax::class,
        'payment_list'                         => \OxidEsales\Eshop\Application\Controller\Admin\PaymentList::class,
        'payment_main'                         => \OxidEsales\Eshop\Application\Controller\Admin\PaymentMain::class,
        'payment_main_ajax'                    => \OxidEsales\Eshop\Application\Controller\Admin\PaymentMainAjax::class,
        'payment_rdfa'                         => \OxidEsales\Eshop\Application\Controller\Admin\PaymentRdfa::class,
        'pricealarm_list'                      => \OxidEsales\Eshop\Application\Controller\Admin\PriceAlarmList::class,
        'pricealarm_mail'                      => \OxidEsales\Eshop\Application\Controller\Admin\PriceAlarmMail::class,
        'pricealarm_main'                      => \OxidEsales\Eshop\Application\Controller\Admin\PriceAlarmMain::class,
        'pricealarm_send'                      => \OxidEsales\Eshop\Application\Controller\Admin\PriceAlarmSend::class,
        'selectlist'                           => \OxidEsales\Eshop\Application\Controller\Admin\SelectListController::class,
        'selectlist_list'                      => \OxidEsales\Eshop\Application\Controller\Admin\SelectListList::class,
        'selectlist_main'                      => \OxidEsales\Eshop\Application\Controller\Admin\SelectListMain::class,
        'selectlist_main_ajax'                 => \OxidEsales\Eshop\Application\Controller\Admin\SelectListMainAjax::class,
        'selectlist_order_ajax'                => \OxidEsales\Eshop\Application\Controller\Admin\SelectListOrderAjax::class,
        'shop'                                 => \OxidEsales\Eshop\Application\Controller\Admin\ShopController::class,
        'shop_default_category_ajax'           => \OxidEsales\Eshop\Application\Controller\Admin\ShopDefaultCategoryAjax::class,
        'shop_license'                         => \OxidEsales\Eshop\Application\Controller\Admin\ShopLicense::class,
        'shop_list'                            => \OxidEsales\Eshop\Application\Controller\Admin\ShopList::class,
        'shop_main'                            => \OxidEsales\Eshop\Application\Controller\Admin\ShopMain::class,
        'shop_performance'                     => \OxidEsales\Eshop\Application\Controller\Admin\ShopPerformance::class,
        'shop_rdfa'                            => \OxidEsales\Eshop\Application\Controller\Admin\ShopRdfa::class,
        'shop_seo'                             => \OxidEsales\Eshop\Application\Controller\Admin\ShopSeo::class,
        'shop_system'                          => \OxidEsales\Eshop\Application\Controller\Admin\ShopSystem::class,
        'sysreq'                               => \OxidEsales\Eshop\Application\Controller\Admin\SystemRequirements::class,
        'sysreq_list'                          => \OxidEsales\Eshop\Application\Controller\Admin\SystemRequirementsList::class,
        'sysreq_main'                          => \OxidEsales\Eshop\Application\Controller\Admin\SystemRequirementsMain::class,
        'systeminfo'                           => \OxidEsales\Eshop\Application\Controller\Admin\SystemInfoController::class,
        'theme_config'                         => \OxidEsales\Eshop\Application\Controller\Admin\ThemeConfiguration::class,
        'theme_list'                           => \OxidEsales\Eshop\Application\Controller\Admin\ThemeList::class,
        'theme_main'                           => \OxidEsales\Eshop\Application\Controller\Admin\ThemeMain::class,
        'tools'                                => \OxidEsales\Eshop\Application\Controller\Admin\ToolsController::class,
        'tools_list'                           => \OxidEsales\Eshop\Application\Controller\Admin\ToolsList::class,
        'tools_main'                           => \OxidEsales\Eshop\Application\Controller\Admin\ToolsMain::class,
        'user_address'                         => \OxidEsales\Eshop\Application\Controller\Admin\UserAddress::class,
        'user_article'                         => \OxidEsales\Eshop\Application\Controller\Admin\UserArticle::class,
        'user_extend'                          => \OxidEsales\Eshop\Application\Controller\Admin\UserExtend::class,
        'user_main'                            => \OxidEsales\Eshop\Application\Controller\Admin\UserMain::class,
        'user_main_ajax'                       => \OxidEsales\Eshop\Application\Controller\Admin\UserMainAjax::class,
        'user_overview'                        => \OxidEsales\Eshop\Application\Controller\Admin\UserOverview::class,
        'user_payment'                         => \OxidEsales\Eshop\Application\Controller\Admin\UserPayment::class,
        'user_remark'                          => \OxidEsales\Eshop\Application\Controller\Admin\UserRemark::class,
        'usergroup'                            => \OxidEsales\Eshop\Application\Controller\Admin\UserGroupController::class,
        'usergroup_list'                       => \OxidEsales\Eshop\Application\Controller\Admin\UserGroupList::class,
        'usergroup_main'                       => \OxidEsales\Eshop\Application\Controller\Admin\UserGroupMain::class,
        'usergroup_main_ajax'                  => \OxidEsales\Eshop\Application\Controller\Admin\UserGroupMainAjax::class,
        'vendor'                               => \OxidEsales\Eshop\Application\Controller\Admin\VendorController::class,
        'vendor_list'                          => \OxidEsales\Eshop\Application\Controller\Admin\VendorList::class,
        'actions_article_ajax'                 => \OxidEsales\Eshop\Application\Controller\Admin\ActionsArticleAjax::class,
        'actions_groups_ajax'                  => \OxidEsales\Eshop\Application\Controller\Admin\ActionsGroupsAjax::class,
        'actions_list'                         => \OxidEsales\Eshop\Application\Controller\Admin\ActionsList::class,
        'actions_main'                         => \OxidEsales\Eshop\Application\Controller\Admin\ActionsMain::class,
        'actions_main_ajax'                    => \OxidEsales\Eshop\Application\Controller\Admin\ActionsMainAjax::class,
        'actions_order_ajax'                   => \OxidEsales\Eshop\Application\Controller\Admin\ActionsOrderAjax::class,
        'admin_content'                        => \OxidEsales\Eshop\Application\Controller\Admin\AdminContent::class,
        'admin_links'                          => \OxidEsales\Eshop\Application\Controller\Admin\AdminLinks::class,
        'admin_news'                           => \OxidEsales\Eshop\Application\Controller\Admin\AdminNews::class,
        'admin_newsletter'                     => \OxidEsales\Eshop\Application\Controller\Admin\AdminNewsletter::class,
        'admin_order'                          => \OxidEsales\Eshop\Application\Controller\Admin\AdminOrder::class,
        'admin_payment'                        => \OxidEsales\Eshop\Application\Controller\Admin\AdminPayment::class,
        'admin_pricealarm'                     => \OxidEsales\Eshop\Application\Controller\Admin\AdminPriceAlarm::class,
        'admin_start'                          => \OxidEsales\Eshop\Application\Controller\Admin\AdminStart::class,
        'admin_user'                           => \OxidEsales\Eshop\Application\Controller\Admin\AdminUser::class,
        'admin_wrapping'                       => \OxidEsales\Eshop\Application\Controller\Admin\AdminWrapping::class,
        'adminlinks_list'                      => \OxidEsales\Eshop\Application\Controller\Admin\AdminlinksList::class,
        'adminlinks_main'                      => \OxidEsales\Eshop\Application\Controller\Admin\AdminlinksMain::class,
        'article'                              => \OxidEsales\Eshop\Application\Controller\Admin\ArticleController::class,
        'article_accessories_ajax'             => \OxidEsales\Eshop\Application\Controller\Admin\ArticleAccessoriesAjax::class,
        'article_attribute'                    => \OxidEsales\Eshop\Application\Controller\Admin\ArticleAttribute::class,
        'article_attribute_ajax'               => \OxidEsales\Eshop\Application\Controller\Admin\ArticleAttributeAjax::class,
        'article_bundle_ajax'                  => \OxidEsales\Eshop\Application\Controller\Admin\ArticleBundleAjax::class,
        'article_crossselling'                 => \OxidEsales\Eshop\Application\Controller\Admin\ArticleCrossselling::class,
        'article_crossselling_ajax'            => \OxidEsales\Eshop\Application\Controller\Admin\ArticleCrosssellingAjax::class,
        'article_extend'                       => \OxidEsales\Eshop\Application\Controller\Admin\ArticleExtend::class,
        'article_extend_ajax'                  => \OxidEsales\Eshop\Application\Controller\Admin\ArticleExtendAjax::class,
        'article_files'                        => \OxidEsales\Eshop\Application\Controller\Admin\ArticleFiles::class,
        'article_main'                         => \OxidEsales\Eshop\Application\Controller\Admin\ArticleMain::class,
        'article_overview'                     => \OxidEsales\Eshop\Application\Controller\Admin\ArticleOverview::class,
        'article_pictures'                     => \OxidEsales\Eshop\Application\Controller\Admin\ArticlePictures::class,
        'article_review'                       => \OxidEsales\Eshop\Application\Controller\Admin\ArticleReview::class,
        'article_selection_ajax'               => \OxidEsales\Eshop\Application\Controller\Admin\ArticleSelectionAjax::class,
        'article_seo'                          => \OxidEsales\Eshop\Application\Controller\Admin\ArticleSeo::class,
        'article_stock'                        => \OxidEsales\Eshop\Application\Controller\Admin\ArticleStock::class,
        'article_userdef'                      => \OxidEsales\Eshop\Application\Controller\Admin\ArticleUserdef::class,
        'article_variant'                      => \OxidEsales\Eshop\Application\Controller\Admin\ArticleVariant::class,
        'attribute'                            => \OxidEsales\Eshop\Application\Controller\Admin\AttributeController::class,
        'attribute_category'                   => \OxidEsales\Eshop\Application\Controller\Admin\AttributeCategory::class,
        'attribute_category_ajax'              => \OxidEsales\Eshop\Application\Controller\Admin\AttributeCategoryAjax::class,
        'attribute_list'                       => \OxidEsales\Eshop\Application\Controller\Admin\AttributeList::class,
        'attribute_main'                       => \OxidEsales\Eshop\Application\Controller\Admin\AttributeMain::class,
        'attribute_main_ajax'                  => \OxidEsales\Eshop\Application\Controller\Admin\AttributeMainAjax::class,
        'attribute_order_ajax'                 => \OxidEsales\Eshop\Application\Controller\Admin\AttributeOrderAjax::class,
        'category'                             => \OxidEsales\Eshop\Application\Controller\Admin\CategoryController::class,
        'category_list'                        => \OxidEsales\Eshop\Application\Controller\Admin\CategoryList::class,
        'category_main'                        => \OxidEsales\Eshop\Application\Controller\Admin\CategoryMain::class,
        'category_main_ajax'                   => \OxidEsales\Eshop\Application\Controller\Admin\CategoryMainAjax::class,
        'category_order'                       => \OxidEsales\Eshop\Application\Controller\Admin\CategoryOrder::class,
        'category_order_ajax'                  => \OxidEsales\Eshop\Application\Controller\Admin\CategoryOrderAjax::class,
        'category_pictures'                    => \OxidEsales\Eshop\Application\Controller\Admin\CategoryPictures::class,
        'category_seo'                         => \OxidEsales\Eshop\Application\Controller\Admin\CategorySeo::class,
        'category_text'                        => \OxidEsales\Eshop\Application\Controller\Admin\CategoryText::class,
        'category_update'                      => \OxidEsales\Eshop\Application\Controller\Admin\CategoryUpdate::class,
        'content_list'                         => \OxidEsales\Eshop\Application\Controller\Admin\ContentList::class,
        'content_main'                         => \OxidEsales\Eshop\Application\Controller\Admin\ContentMain::class,
        'content_seo'                          => \OxidEsales\Eshop\Application\Controller\Admin\ContentSeo::class,
        'country'                              => \OxidEsales\Eshop\Application\Controller\Admin\CountryController::class,
        'country_list'                         => \OxidEsales\Eshop\Application\Controller\Admin\CountryList::class,
        'country_main'                         => \OxidEsales\Eshop\Application\Controller\Admin\CountryMain::class,
        'delivery'                             => \OxidEsales\Eshop\Application\Controller\Admin\DeliveryController::class,
        'delivery_articles'                    => \OxidEsales\Eshop\Application\Controller\Admin\DeliveryArticles::class,
        'delivery_articles_ajax'               => \OxidEsales\Eshop\Application\Controller\Admin\DeliveryArticlesAjax::class,
        'delivery_categories_ajax'             => \OxidEsales\Eshop\Application\Controller\Admin\DeliveryCategoriesAjax::class,
        'delivery_groups_ajax'                 => \OxidEsales\Eshop\Application\Controller\Admin\DeliveryGroupsAjax::class,
        'delivery_list'                        => \OxidEsales\Eshop\Application\Controller\Admin\DeliveryList::class,
        'delivery_main'                        => \OxidEsales\Eshop\Application\Controller\Admin\DeliveryMain::class,
        'delivery_main_ajax'                   => \OxidEsales\Eshop\Application\Controller\Admin\DeliveryMainAjax::class,
        'delivery_users'                       => \OxidEsales\Eshop\Application\Controller\Admin\DeliveryUsers::class,
        'delivery_users_ajax'                  => \OxidEsales\Eshop\Application\Controller\Admin\DeliveryUsersAjax::class,
        'deliveryset'                          => \OxidEsales\Eshop\Application\Controller\Admin\DeliverySetController::class,
        'deliveryset_country_ajax'             => \OxidEsales\Eshop\Application\Controller\Admin\DeliverySetCountryAjax::class,
        'deliveryset_groups_ajax'              => \OxidEsales\Eshop\Application\Controller\Admin\DeliverySetGroupsAjax::class,
        'deliveryset_list'                     => \OxidEsales\Eshop\Application\Controller\Admin\DeliverySetList::class,
        'deliveryset_main'                     => \OxidEsales\Eshop\Application\Controller\Admin\DeliverySetMain::class,
        'deliveryset_main_ajax'                => \OxidEsales\Eshop\Application\Controller\Admin\DeliverySetMainAjax::class,
        'deliveryset_payment'                  => \OxidEsales\Eshop\Application\Controller\Admin\DeliverySetPayment::class,
        'deliveryset_payment_ajax'             => \OxidEsales\Eshop\Application\Controller\Admin\DeliverySetPaymentAjax::class,
        'deliveryset_rdfa'                     => \OxidEsales\Eshop\Application\Controller\Admin\DeliverySetRdfa::class,
        'deliveryset_users'                    => \OxidEsales\Eshop\Application\Controller\Admin\DeliverySetUsers::class,
        'deliveryset_users_ajax'               => \OxidEsales\Eshop\Application\Controller\Admin\DeliverySetUsersAjax::class,
        'diagnostics'                          => \OxidEsales\Eshop\Application\Controller\Admin\DiagnosticsController::class,
        'diagnostics_list'                     => \OxidEsales\Eshop\Application\Controller\Admin\DiagnosticsList::class,
        'diagnostics_main'                     => \OxidEsales\Eshop\Application\Controller\Admin\DiagnosticsMain::class,
        'discount'                             => \OxidEsales\Eshop\Application\Controller\Admin\DiscountController::class,
        'discount_articles'                    => \OxidEsales\Eshop\Application\Controller\Admin\DiscountArticles::class,
        'discount_articles_ajax'               => \OxidEsales\Eshop\Application\Controller\Admin\DiscountArticlesAjax::class,
        'discount_categories_ajax'             => \OxidEsales\Eshop\Application\Controller\Admin\DiscountCategoriesAjax::class,
        'discount_groups_ajax'                 => \OxidEsales\Eshop\Application\Controller\Admin\DiscountGroupsAjax::class,
        'discount_item_ajax'                   => \OxidEsales\Eshop\Application\Controller\Admin\DiscountItemAjax::class,
        'discount_list'                        => \OxidEsales\Eshop\Application\Controller\Admin\DiscountList::class,
        'discount_main'                        => \OxidEsales\Eshop\Application\Controller\Admin\DiscountMain::class,
        'discount_main_ajax'                   => \OxidEsales\Eshop\Application\Controller\Admin\DiscountMainAjax::class,
        'discount_users'                       => \OxidEsales\Eshop\Application\Controller\Admin\DiscountUsers::class,
        'discount_users_ajax'                  => \OxidEsales\Eshop\Application\Controller\Admin\DiscountUsersAjax::class,
        'dyn_econda'                           => \OxidEsales\Eshop\Application\Controller\Admin\DynEconda::class,
        'content'                              => \OxidEsales\Eshop\Application\Controller\ContentController::class,
        'links'                                => \OxidEsales\Eshop\Application\Controller\LinksController::class,
        'news'                                 => \OxidEsales\Eshop\Application\Controller\NewsController::class,
        'newsletter'                           => \OxidEsales\Eshop\Application\Controller\NewsletterController::class,
        'pricealarm'                           => \OxidEsales\Eshop\Application\Controller\PriceAlarmController::class,
        'account_noticelist'                   => \OxidEsales\Eshop\Application\Controller\AccountNoticeListController::class,
        'oxadminlist'                          => \OxidEsales\Eshop\Application\Controller\Admin\AdminListController::class,
        'order_list'                           => \OxidEsales\Eshop\Application\Controller\Admin\OrderList::class,
        'user_list'                            => \OxidEsales\Eshop\Application\Controller\Admin\UserList::class,
        'details'                              => \OxidEsales\Eshop\Application\Controller\ArticleDetailsController::class,
        'oxubase'                              => \OxidEsales\Eshop\Application\Controller\FrontendController::class,
        'alist'                                => \OxidEsales\Eshop\Application\Controller\ArticleListController::class,
        'user'                                 => \OxidEsales\Eshop\Application\Controller\UserController::class,
        'account'                              => \OxidEsales\Eshop\Application\Controller\AccountController::class,
        'basket'                               => \OxidEsales\Eshop\Application\Controller\BasketController::class,
        'compare'                              => \OxidEsales\Eshop\Application\Controller\CompareController::class,
        'order'                                => \OxidEsales\Eshop\Application\Controller\OrderController::class,
        'payment'                              => \OxidEsales\Eshop\Application\Controller\PaymentController::class,
        'recommlist'                           => \OxidEsales\Eshop\Application\Controller\RecommListController::class,
        'rss'                                  => \OxidEsales\Eshop\Application\Controller\RssController::class,
        'search'                               => \OxidEsales\Eshop\Application\Controller\SearchController::class,
        'start'                                => \OxidEsales\Eshop\Application\Controller\StartController::class,
        'thankyou'                             => \OxidEsales\Eshop\Application\Controller\ThankYouController::class,
        'wishlist'                             => \OxidEsales\Eshop\Application\Controller\WishListController::class,
        'wrapping'                             => \OxidEsales\Eshop\Application\Controller\WrappingController::class,
        'oxstart'                              => \OxidEsales\Eshop\Application\Controller\OxidStartController::class,
        'dyn_interface'                        => \OxidEsales\Eshop\Application\Controller\Admin\DynamicInterface::class,
        'dyn_screen'                           => \OxidEsales\Eshop\Application\Controller\Admin\DynamicScreenController::class,
        'dynexportbase'                        => \OxidEsales\Eshop\Application\Controller\Admin\DynamicExportBaseController::class,
        'genimport_main'                       => \OxidEsales\Eshop\Application\Controller\Admin\GenericImportMain::class,
        'object_seo'                           => \OxidEsales\Eshop\Application\Controller\Admin\ObjectSeo::class,
        'shop_config'                          => \OxidEsales\Eshop\Application\Controller\Admin\ShopConfiguration::class,
        'clearcookies'                         => \OxidEsales\Eshop\Application\Controller\ClearCookiesController::class,
        'account_order'                        => \OxidEsales\Eshop\Application\Controller\AccountOrderController::class,
        'account_downloads'                    => \OxidEsales\Eshop\Application\Controller\AccountDownloadsController::class,
        'account_newsletter'                   => \OxidEsales\Eshop\Application\Controller\AccountNewsletterController::class,
        'account_password'                     => \OxidEsales\Eshop\Application\Controller\AccountPasswordController::class,
        'account_recommlist'                   => \OxidEsales\Eshop\Application\Controller\AccountRecommlistController::class,
        'contact'                              => \OxidEsales\Eshop\Application\Controller\ContactController::class,
        'credits'                              => \OxidEsales\Eshop\Application\Controller\CreditsController::class,
        'download'                             => \OxidEsales\Eshop\Application\Controller\DownloadController::class,
        'exceptionerror'                       => \OxidEsales\Eshop\Application\Controller\ExceptionErrorController::class,
        'forgotpwd'                            => \OxidEsales\Eshop\Application\Controller\ForgotPasswordController::class,
        'invite'                               => \OxidEsales\Eshop\Application\Controller\InviteController::class,
        'moredetails'                          => \OxidEsales\Eshop\Application\Controller\MoreDetailsController::class,
        'recommadd'                            => \OxidEsales\Eshop\Application\Controller\RecommendationAddController::class,
        'register'                             => \OxidEsales\Eshop\Application\Controller\RegisterController::class,
        'suggest'                              => \OxidEsales\Eshop\Application\Controller\SuggestController::class,
        'tpl'                                  => \OxidEsales\Eshop\Application\Controller\TemplateController::class,
        'oxwactions'                           => \OxidEsales\Eshop\Application\Component\Widget\Actions::class,
        'oxwbetanote'                          => \OxidEsales\Eshop\Application\Component\Widget\BetaNote::class,
        'oxwcategorytree'                      => \OxidEsales\Eshop\Application\Component\Widget\CategoryTree::class,
        'oxwinformation'                       => \OxidEsales\Eshop\Application\Component\Widget\Information::class,
        'oxwrating'                            => \OxidEsales\Eshop\Application\Component\Widget\Rating::class,
        'oxwservicemenu'                       => \OxidEsales\Eshop\Application\Component\Widget\ServiceMenu::class,
        'oxwarticlebox'                        => \OxidEsales\Eshop\Application\Component\Widget\ArticleBox::class,
        'oxwcookienote'                        => \OxidEsales\Eshop\Application\Component\Widget\CookieNote::class,
        'oxwlanguagelist'                      => \OxidEsales\Eshop\Application\Component\Widget\LanguageList::class,
        'oxwrecommendation'                    => \OxidEsales\Eshop\Application\Component\Widget\Recommendation::class,
        'oxwarticledetails'                    => \OxidEsales\Eshop\Application\Component\Widget\ArticleDetails::class,
        'oxwcurrencylist'                      => \OxidEsales\Eshop\Application\Component\Widget\CurrencyList::class,
        'oxwmanufacturerlist'                  => \OxidEsales\Eshop\Application\Component\Widget\ManufacturerList::class,
        'oxwreview'                            => \OxidEsales\Eshop\Application\Component\Widget\Review::class,
        'oxwvendorlist'                        => \OxidEsales\Eshop\Application\Component\Widget\VendorList::class,
        'oxwidget'                             => \OxidEsales\Eshop\Application\Component\Widget\WidgetController::class,
        'oxwminibasket'                        => \OxidEsales\Eshop\Application\Component\Widget\MiniBasket::class,
        'oxwservicelist'                       => \OxidEsales\Eshop\Application\Component\Widget\ServiceList::class,
        'oxadminview'                          => \OxidEsales\Eshop\Application\Controller\Admin\AdminController::class,
        'oxadmindetails'                       => \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController::class,
        'article_list'                         => \OxidEsales\Eshop\Application\Controller\Admin\ArticleList::class,
        'ajaxlistcomponent'                    => \OxidEsales\Eshop\Application\Controller\Admin\ListComponentAjax::class,
    ];

    /**
     * All available controller maps will be merged together like this: CE <- PE <- EE
     *
     * @return array Edition specific mapping of controller keys to classes
     */
    public function getControllerMap()
    {
        return $this->controllerMap;
    }
}
