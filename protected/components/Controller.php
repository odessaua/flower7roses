<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends RController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();

	/**
	 * @var string
	 */
	public $pageKeywords;

	/**
	 * @var string
	 */
	public $pageDescription;

	/**
	 * @var string
	 */
	private $_pageTitle;

    /*
     * @var array all info about current language
     */
    public $language_info;

    /**
     * Дополнительные SEO-элементы для страниц Категорий
     * rel="prev"
     * rel="next"
     * @var array
     */
    public $rels = array(
        'prev' => '',
        'next' => '',
    );

    /*
     *
     */
    public $layout_params = array();

	/**
	 * Set layout and view
	 * @param mixed $model
	 * @param string $view Default view name
	 * @return string
	 */
	// public function __construct($id,$module=null){
 //    parent::__construct($id,$module);
 //    // If there is a post-request, redirect the application to the provided url of the selected language 
 //    if(isset($_POST['language'])) {
 //        $lang = $_POST['language'];
 //        $MultilangReturnUrl = $_POST[$lang];
 //        $this->redirect($MultilangReturnUrl);
 //    }

    // Set the application language if provided by GET, session or cookie
 //    if(isset($_GET['language'])) {
 //        Yii::app()->language = $_GET['language'];
 //        Yii::app()->user->setState('language', $_GET['language']); 
 //        $cookie = new CHttpCookie('language', $_GET['language']);
 //        $cookie->expire = time() + (60*60*24*365); // (1 year)
 //        Yii::app()->request->cookies['language'] = $cookie; 
 //    }
 //    else if (Yii::app()->user->hasState('language'))
 //        Yii::app()->language = Yii::app()->user->getState('language');
 //    else if(isset(Yii::app()->request->cookies['language']))
 //        Yii::app()->language = Yii::app()->request->cookies['language']->value;
	// }
	public function __construct($id,$module=null)
    {
        parent::__construct($id,$module);
        // If there is a post-request, redirect the application to the provided url of the selected language
        if(isset($_POST['language'])) {
            $lang = $_POST['language'];
            $MultilangReturnUrl = $_POST[$lang];
            $this->redirect($MultilangReturnUrl);
        }
        // Set the application language if provided by GET, session or cookie
//        if(isset($_GET['language'])) {
//            Yii::app()->language = $_GET['language'];
//            Yii::app()->user->setState('language', $_GET['language']);
//            $cookie = new CHttpCookie('language', $_GET['language']);
//            $cookie->expire = time() + (60*60*24*365); // (1 year)
//            Yii::app()->request->cookies['language'] = $cookie;
//        }
//        else if (Yii::app()->user->hasState('language'))
//            Yii::app()->language = Yii::app()->user->getState('language');
//        else if(isset(Yii::app()->request->cookies['language']))
//            Yii::app()->language = Yii::app()->request->cookies['language']->value;

        // get current language info
        $this->getCurrentLangInfo();
    }

	public function createMultilanguageReturnUrl($lang='en'){
	    if (count($_GET)>0){
	        $arr = $_GET;
	        $arr['language']= $lang;
	    }
	    else 
	        $arr = array('language'=>$lang);
	    return $this->createUrl('', $arr);
	}
	protected function setDesign($model, $view)
	{
		// Set layout
		if ($model->layout)
			$this->layout = $model->layout;

		// Use custom page view
		if ($model->view)
			$view = $model->view;

		return $view;
	}

	/**
	 * @param $message
	 */
	public  function addFlashMessage($message)
	{
		$currentMessages = Yii::app()->user->getFlash('messages');

		if (!is_array($currentMessages))
			$currentMessages = array();

		Yii::app()->user->setFlash('messages', CMap::mergeArray($currentMessages, array($message)));
	}

	public function setPageTitle($title)
	{
		$this->_pageTitle=$title;
	}


	public function getPageTitle()
	{
		$title = Yii::app()->settings->get('core', 'siteName');
		if(!empty($this->_pageTitle)){
		    if(mb_strpos($this->_pageTitle, ' / ' . $title) === false){
			    $title=$this->_pageTitle .= ' / ' . $title;
            }
            else{
		        $title = $this->_pageTitle;
            }
        }
		return $title;
	}

    public function getCitySeo()
    {
        $return = array(
            'description' => '',
            'keywords' => '',
            'text' => '',
            'title' => '7Roses',
        );
        $lang= Yii::app()->language;
        if($lang == 'ua')
            $lang = 'uk';
        $langArray = SSystemLanguage::model()->findByAttributes(array('code'=>$lang));
        $city_id = Yii::app()->session['_city'];
        if(!empty($city_id)){
            $city_seo = CitySeo::model()->findByAttributes(array('city_id' => $city_id, 'lang_id' => $langArray->id));
            if(!empty($city_seo)){
                $return = array(
                    'description' => $city_seo->seo_description,
                    'keywords' => $city_seo->seo_keywords,
                    'text' => $city_seo->seo_text,
                    'title' => $city_seo->seo_title,
                );
            }
        }
        return $return;
    }

    public function getCurrentLangInfo()
    {
        $lang= Yii::app()->language;
        if($lang == 'ua')
            $lang = 'uk';
        $this->language_info = SSystemLanguage::model()->findByAttributes(array('code'=>$lang));
    }

    public function createNewLanguageUrl($key = 'en')
    {
        $uri = Yii::app()->request->url;
        return MLhelper::addSpecifiedLangToUrl($uri, $key);
    }

    /**
     * информация о городе по ID
     * @param int $city_id
     * @param bool $translate - с переводом названия или без
     * @param string $lang - язык перевода названия (если не указан – то берём текущий)
     * @return object CActiveRecord
     */
    public function getCityInfo($city_id, $translate = false, $lang = '')
    {
        $language = (empty($lang))
            ? $this->language_info // текущий язык
            : SSystemLanguage::model()->findByAttributes(array('code'=>$lang)); // язык по коду из аргумента
        if(!empty($translate)){
            $city = City::model()->language($language->id)->findByPk($city_id); // с переводом
        }
        else{
            $city = City::model()->language(0)->findByPk($city_id); // без перевода
        }
        return $city;
    }

    /**
     * информация о текущем городе, сохранённом в сессии
     * @param bool $translate - с переводом названия или без
     * @param string $lang - язык перевода названия (если не указан – то берём текущий)
     * @return object CActiveRecord
     */
    public function getCurrentCityInfo($translate = false, $lang = '')
    {
        return (!empty(Yii::app()->session['_city']))
            ? $this->getCityInfo(Yii::app()->session['_city'], $translate, $lang) // город из сессии
            : $this->getDefaultCityInfo($translate, $lang); // город по умолчанию (Киев)
    }

    /**
     * город по умолчанию – Киев, ID = 908
     * @param bool $translate - с переводом названия или без
     * @param string $lang - язык перевода названия (если не указан – то берём текущий)
     * @return object CActiveRecord
     */
    public function getDefaultCityInfo($translate = false, $lang = '')
    {
        return $this->getCityInfo(908, $translate, $lang); // Киев, ID = 908
    }

}