<?php

Yii::import('application.modules.store.models.StoreCurrency');

/**
 * Class to work with currencies
 */
class SCurrencyManager extends CComponent
{

	/**
	 * @var array available currencies
	 */
	private $_currencies = array();

	/**
	 * @var StoreCurrency main currency
	 */
	private $_main;

	/**
	 * @var StoreCurrency current active currency
	 */
	private $_active;

	/**
	 * @var StoreCurrency default currency
	 */
	private $_default;

	/**
	 * @var string
	 */
	public $cacheKey = 'currency_manager';

	public function init()
	{
		foreach($this->loadCurrencies() as $currency)
		{
			$this->_currencies[$currency->id] = $currency;
			if($currency->main)
				$this->_main = $currency;
			if($currency->default)
				$this->_default = $currency;
		}

		$this->setCurrencyByIP();
	}

	/**
	 * @return array
	 */
	public function getCurrencies()
	{
		return $this->_currencies;
	}

	/**
	 * Detect user active currency
	 * @return StoreCurrency
	 */
	public function detectActive()
	{
		// Detect currency from session
		$sessCurrency = Yii::app()->session['currency'];

		if($sessCurrency && isset($this->_currencies[$sessCurrency]))
			return $this->_currencies[$sessCurrency];
		return $this->_default;
	}

	/**
	 * @param int $id currency id
	 */
	public function setActive($id)
	{
		if(isset($this->_currencies[$id]))
			$this->_active = $this->_currencies[$id];
		else
			$this->_active = $this->_default;

		Yii::app()->session['currency'] = $this->_active->id;
	}

	/**
	 * get active currency
	 * @return StoreCurrency
	 */
	public function getActive()
	{
		return $this->_active;
	}

	/**
	 * @return StoreCurrency main currency
	 */
	public function getMain()
	{
		return $this->_main;
	}

	/**
	 * Convert sum from main currency to selected currency
	 * @param mixed $sum
	 * @param mixed $id StoreCurrency. If not set, sum will be converted to active currency
	 * @return float converted sum
	 */
	public function convert($sum, $id=null)
	{
		if($id !== null && isset($this->_currencies[$id]))
			$currency = $this->_currencies[$id];
		else
			$currency = $this->_active;

		return $currency->rate * $sum;
	}

	/**
	 * Convert from active currency to main
	 * @param $sum
	 * @return float
	 */
	public function activeToMain($sum)
	{
		return $sum / $this->getActive()->rate;
	}

	/**
	 * @return array
	 */
	public function loadCurrencies()
	{
		$currencies = Yii::app()->cache->get($this->cacheKey);

		if(!$currencies)
		{
			$currencies = StoreCurrency::model()->findAll();
			Yii::app()->cache->set($this->cacheKey, $currencies);
		}

		return $currencies;
	}

    /**
     * geo-информация о пользователе
     * @return array|mixed
     */
    public function geoIpInfo()
    {
        $ipAddress = Yii::app()->request->userHostAddress; // real user IP
//        $ipAddress = '192.196.142.22'; // test France
//        $ipAddress = '188.163.97.7'; // test Ukraine
//        $ipAddress = '72.229.28.185'; // test United States
        $ip_key = "9a531e5be48d22f2df5d421eafbb87c2b376206e7314174e7e7c131104e44dae";
        $query = "https://api.ipinfodb.com/v3/ip-city/?key=" . $ip_key . "&ip=" . $ipAddress . "&format=json";
        $json = file_get_contents($query);
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $data = array();
        }
        return $data;
    }

    /**
     * валюта по IP-информации о пользователе:
     * Украина = гривна
     * Европа = евро
     * Остальные = доллар
     */
    public function setCurrencyByIP()
    {
        Yii::app()->session['currency'] = ''; // uncomment for testing
        // проверяем валюту в сессии
        $sessCurrency = Yii::app()->session['currency'];
        if(!empty($sessCurrency)){
            // пользователь сам выбрал валюту
            // или её уже назначили по IP ранее в этой сессии пользователя
            // делаем активной валюту из сессии
            $this->setActive($sessCurrency);
            return true;
        }

        $ip_info = $this->geoIpInfo();
        $currencies = $this->getCurrencies();
        if(!empty($ip_info['countryCode']) && !empty($currencies)){
            $euro_countries = array(
                'AT', 'BE', 'CY', 'EE', 'FI', 'FR', 'DE', 'GR', 'IE', 'IT',
                'LV', 'LT', 'LU', 'MT', 'NL', 'PT', 'SK', 'SI', 'ES',
            );
            $ua = 'UA';
            $set_iso = '';
            if(in_array($ip_info['countryCode'], $euro_countries)){
                // EUR
                $set_iso = 'EUR';
            }
            elseif($ip_info['countryCode'] == $ua){
                // UAH
                $set_iso = 'UAH';
            }
            if(!empty($set_iso)){
                // устанавливаем новую активную валюту по IP
                foreach ($currencies as $currency) {
                    if($currency->iso == $set_iso){
                        $this->setActive($currency->id);
                        break;
                    }
                }
                return true;
            }
        }
        $this->setActive($this->detectActive()->id); // default
        return true;
    }

    /**
     * форматирование цены по шаблону – или в формат {знак_валюты}{сумма}
     * @param $sum
     * @return mixed|string
     */
    public function format($sum)
    {
        if(
            !empty($this->_active->price_format) &&
            (strpos($this->_active->price_format, '{sum}') !== false)
        ) {
            return str_replace('{sum}', $sum, $this->_active->price_format);
        }
        else {
            return $this->_active->symbol . $sum;
        }
    }
}
