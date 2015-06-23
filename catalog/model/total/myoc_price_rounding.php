<?php
class ModelTotalMyocPriceRounding extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
		$title = @unserialize($this->config->get('myoc_price_rounding_description'));

		$display = $this->config->get('myoc_price_rounding_display');

		$login_required = $this->config->get('myoc_price_rounding_login');

		$rules = @unserialize($this->config->get('myoc_price_rounding_rule'));

		$rule_exist = false;

		$op = '';
		
		$display_value = 0;

		$round_value = 0;

		$currency_total = $this->currency->convert($total, $this->config->get('config_currency'), $this->currency->getCode());

		foreach ($rules as $rule) {
			//store
			if(isset($rule['store']) && in_array($this->config->get('config_store_id'), $rule['store']))
			{
				//login
				if(!$login_required || ($this->customer->isLogged() && isset($rule['customer_group']) && in_array($this->customer->getGroupId(), $rule['customer_group'])))
				{
					//currency
					if(isset($rule['currency']) && in_array($this->currency->getId(), $rule['currency']))
					{
						//price range
						if($currency_total >= $rule['range_from'] && $currency_total <= $rule['range_to'] && $rule['nearest'] <= $currency_total)
						{
							$rule_exist = true;

							if($rule['rounding'] == 'fix') {
								//get fixed nearest value
								$round_value = floor($currency_total/$this->round_up($rule['nearest'])) * $this->round_up($rule['nearest']) + $rule['nearest'];
								
								//if direction == near
								if($rule['direction'] == 'near' && abs($round_value - $currency_total) > ($this->round_up($rule['nearest']) / 2)) {
									if(($round_value - $currency_total) > 0) {
										$rule['direction'] = 'down'; //+ve
									} else {
										$rule['direction'] = 'up'; //-ve
									}
								}
								//adjust direction
								switch ($rule['direction']) {
									case 'up':
										$round_value += ($round_value < $currency_total ? 1 * $this->round_up($rule['nearest']) : 0);
										break;
									case 'down':
										$round_value -= ($round_value > $currency_total ? 1 * $this->round_up($rule['nearest']) : 0);
										break;
									default: //nearest
										break;
								}
							} elseif ($rule['rounding'] == 'mux') {
								//adjust direction
								switch ($rule['direction']) {
									case 'up':
										$round_value = ceil($currency_total / $rule['nearest']) * $rule['nearest'];
										break;
									case 'down':
										$round_value = floor($currency_total / $rule['nearest']) * $rule['nearest'];
										break;
									default: //nearest
										$round_value = round($currency_total / $rule['nearest']) * $rule['nearest'];
										break;
								}
							}

							$round_value = round($round_value, $this->currency->getDecimalPlace()) - round($currency_total, $this->currency->getDecimalPlace());

							break;
						}
					}
				}
			}
		}

		if(!$rule_exist) {
			return;
		}

	 	//display
		if($display == 'diff') {
			if($round_value < 0) { //-ve
				$op = '-';
			}
			$display_value = abs($round_value);
		} elseif ($display == 'total') {
			$display_value = $currency_total + $round_value;
		}
		$display_value = $this->currency->convert($display_value, $this->currency->getCode(), $this->config->get('config_currency'));
		$round_value = $this->currency->convert($round_value, $this->currency->getCode(), $this->config->get('config_currency'));

		$total_data[] = array(
			'code'       => 'myoc_price_rounding',
			'title'      => $title[$this->config->get('config_language_id')]['title'],
			'text'       => $op . $this->currency->format($display_value),
			'value'      => $round_value,
			'sort_order' => $this->config->get('myoc_price_rounding_sort_order')
		);

		$total += $round_value;
	}

	private function round_up($value) {
		//return 10s multiplier of decimal places
		//e.g. .01, .1, 1, 10, 100, etc..
		$multiplier = 1;
		if($value >= 1) {
			while ($value >= 1) {
				$value /= 10;
				$multiplier *= 10;
			}
		} elseif ($value < 0.1) {
			while ($value < 0.1) {
				$value *= 10;
				$multiplier /= 10;
			}
		}
		return $multiplier;
	}
}
?>