<?php
/* User:lyt123; Date:2017/9/11; QQ:1067081452 */
interface ProviderInterface {
    public function getLowestPrice($location);
    public function book($location);
}

class Uses {

    public function bookLocation(ProviderInterface $provider, $location)
    {
        $amountCharged = $provider->book($location);

        $this->logBookedLocation($location, $amountCharged);
    }
}

$location = 'Hilton, Dallas';

$cheapestProvider = $this->findCheapest($location, array(
    new PricelineProvider,
    new OrbitzProvider,
));

$user->bookLocation($cheapestProvider, $location);
