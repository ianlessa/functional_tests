<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Behat\Mink\Exception\ResponseTextException;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    //based on example from http://docs.behat.org/en/v2.5/cookbook/using_spin_functions.html
    public function spin ($lambda, $wait = 15)
    {
        for ($i = 0; $i < $wait; $i++)
        {
            try {
                if ($lambda($this)) {
                    return true;
                }
            } catch (Exception $e) {
                //var_dump($e->getMessage());
            }

            usleep(250000);
        }

        $backtrace = debug_backtrace();

        throw new Exception(
            "Timeout thrown by " . $backtrace[1]['class'] . "::" . $backtrace[1]['function'] . "()\n"
            //$backtrace[1]['file'] . ", line " . $backtrace[1]['line']
        );
    }

    /**
     * @Then /^I wait for the suggestion box to appear$/
     */
    public function iWaitForTheSuggestionBoxToAppear()
    {
        $this->getSession()->wait(10000,
            "$('.suggestions-results').children().length > 0"
        );
    }

    /**
     * @Then /^I wait for url to become "([^"]*)"$/
     */
    public function iWaitForUrlToBecome($url)
    {


        try {
            $this->spin(function ($context) use ($url) {

                try {
                    $context->assertSession()->addressEquals($this->locatePath($url));
                    return true;
                }
                catch(ResponseTextException $e) {
                    // NOOP
                }
                return false;
            });
        }catch(Exception $e) {

        }

    }


}

