<?php

class InventoryItemWithSkuLocale {
    public array $availability;
    public string $condition = "SELLER_REFURBISHED";
    public string $conditionDescription;
    public string $conditionDescriptors;
    public string $locale;
    public string $packageWeightAndSize;
    public string $product;
    public string $sku;

    function __construct(string $sku, int $onHand) {
        $this->availability = [
            "shipToLocationAvailability" => [
                "availabilityDistributions" => [
                    "fulfillmentTime" => [
                        "value" => 3,
                        "unit" => "BUSINESS_DAY"
                    ]
                ]
                "quantity" => $onHand
            ]
        ];
    }
}