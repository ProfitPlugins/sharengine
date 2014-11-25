<?php

class seIntegrations
{
    public function __construct()
    {

        $options = get_option( SE_OPTIONS );

        if($options['integrations']['infusionsoft']['enabled'] ==1)
        {

            add_filter("se_custom_categories", array($this, "addIntegrationUserFields"));
            add_filter("se_shared_link_modifiers", array($this, "infusionSoftLink"));
        }



    }

    public function infusionSoftLink($modifiers)
    {
        $options = get_option( SE_OPTIONS );
        $domain = $options['integrations']['infusionsoft']['subdomain'];
        $ref = $options['integrations']['infusionsoft']['referral'];

        $modifiers["infusionsoft"]['url'] =  "https://" . $domain . ".infusionsoft.com/go/" . $ref . "/[infusionsoft_ref]/?p=[url]";
        $modifiers["infusionsoft"]["affiliate_params"] = array("infusionsoft_ref");


        return $modifiers;
    }

    public function addIntegrationUserFields($categories)
    {
        $categories['infusionsoft']['name'] = "InfusionSoft Field";
        $categories['infusionsoft']['fields'][1]['name'] = "infusionsoft_ref";
        $categories['infusionsoft']['fields'][1]['text'] = "Infusionsoft Referrer Information";
        $categories['infusionsoft']['fields'][1]['description'] = "Enter your Infusionsoft Referrer Code";

        return $categories;
    }
}

$integrations = new seIntegrations();