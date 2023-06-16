<?php

/**
 * @charset UTF-8
 *
 * Задание 3
 * В данный момент компания X работает с двумя перевозчиками
 * 1. Почта России
 * 2. DHL
 * У каждого перевозчика своя формула расчета стоимости доставки посылки
 * Почта России до 10 кг берет 100 руб, все что cвыше 10 кг берет 1000 руб
 * DHL за каждый 1 кг берет 100 руб
 * Задача:
 * Необходимо описать архитектуру на php из методов или классов для работы с
 * перевозчиками на предмет получения стоимости доставки по каждому из указанных
 * перевозчиков, согласно данным формулам.
 * При разработке нужно учесть, что количество перевозчиков со временем может
 * возрасти. И делать расчет для новых перевозчиков будут уже другие программисты.
 * Поэтому необходимо построить архитектуру так, чтобы максимально минимизировать
 * ошибки программиста, который будет в дальнейшем делать расчет для нового
 * перевозчика, а также того, кто будет пользоваться данным архитектурным решением.
 *
 */

# Использовать данные:
# любые

interface IDeliveryCostCalculate
{
    public function calculateDeliveryCost($mass): int;
}


class DHLDelivery implements IDeliveryCostCalculate
{
	const PAY_VALUE = 10000; // в копейках, чтобы не возникало float

    public function calculateDeliveryCost($mass): int
    {
        return (ceil($mass) * self::PAY_VALUE);
    }
}

class PochtaRFDelivery implements IDeliveryCostCalculate
{
	const MASS_THRESHOLD = 10;
	const MIN_PAY_VALUE = 10000; // в копейках, чтобы не возникало float
	const MAX_PAY_VALUE = 100000; // в копейках, чтобы не возникало float

    public function calculateDeliveryCost($mass): int
    {
		if ($mass <= self::MASS_THRESHOLD ){
			return self::MIN_PAY_VALUE;
		} else {
			return self::MAX_PAY_VALUE;
		}
    }
}

class Delivery
{
	private float $mass;
    private IDeliveryCostCalculate $calculator;

    public function __construct(float $mass, IDeliveryCostCalculate $calculator) {
        $this->mass = $mass;
        $this->calculator = $calculator;
    }

    public function calculateCost()
    {
        return $this->calculator->calculateDeliveryCost($this->mass);
    }
}

// пример клиентского кода:
// создание экземпляра доставки можно обернуть в фабрику

$mass = 11;

$newDelivery = new Delivery($mass, new PochtaRFDelivery());
echo($newDelivery->calculateCost());

$newDelivery = new Delivery($mass, new DHLDelivery());
echo($newDelivery->calculateCost());
?>