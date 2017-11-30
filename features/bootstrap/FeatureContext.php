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
    public function spin ($lambda, $wait = 60)
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
            "Timeout ($wait seconds) thrown by " . $backtrace[1]['class'] . "::" . $backtrace[1]['function'] . "()\n"
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

    /**
    * @When /^(?:|I )click in element "(?P<element>(?:[^"]|\\")*)"$/
    */
    public function clickInElement($element)
    {
        $session = $this->getSession();

        $locator = $this->fixStepArgument($element);
        $xpath = $session->getSelectorsHandler()->selectorToXpath('css', $locator);
        $element = $this->getSession()->getPage()->find(
            'xpath',
            $xpath
        );
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not find element'));
        }
	//var_dump($element->getAttribute('title'));
        $element->click();
    }

     /**
     * @When /^(?:|I )wait for element "(?P<element>(?:[^"]|\\")*)" to appear$/
     * @Then /^(?:|I )should see element "(?P<element>(?:[^"]|\\")*)" appear$/
     * @param $element
     * @throws \Exception
     */
    public function iWaitForElementToAppear($element)
    {     
        $this->spin(function(FeatureContext $context) use ($element) {
            try {
                $context->assertElementOnPage($element);
                return true;
            }
            catch(ResponseTextException $e) {
                // NOOP
            }
            return false;
        });
    }

    /** 
     * @When /^(?:|I )wait for element "(?P<element>(?:[^"]|\\")*)" to appear, for (?P<wait>(?:\d+)*) seconds$/
     * @param $element
     * @param $wait
     * @throws \Exception
     */
    public function iWaitForElementToAppearForNSeconds($element,$wait)
    {       
        $this->spin(function(FeatureContext $context) use ($element) {
            try {
                $context->assertElementOnPage($element);
                return true;
            }
            catch(ResponseTextException $e) {
                // NOOP
            }
            return false;
        },$wait);
    }  

     /**
     * @When /^(?:|I )wait for element "(?P<element>(?:[^"]|\\")*)" to become visible$/
     * @param $element
     * @throws \Exception
     */
    public function iWaitForElementToBecomeVisible($element)
    {
        $session = $this->getSession();

        $locator = $this->fixStepArgument($element);
        $xpath = $session->getSelectorsHandler()->selectorToXpath('css', $locator);
        $element = $this->getSession()->getPage()->find(
            'xpath',
            $xpath
        );
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not find element'));
        }


        $this->spin(function() use ($element) {
            try {
                return $element->isVisible();
                //return true;
            }
            catch(ResponseTextException $e) {
                // NOOP
            }
            return false;
        });
    }


    /**
    * @when /^(?:|I )follow the element "(?P<element>(?:[^"]|\\")*)" href$/ 
    */    
    public function iFollowTheElementHref($element) {

        $session = $this->getSession();
 
        $locator = $this->fixStepArgument($element);
        $xpath = $session->getSelectorsHandler()->selectorToXpath('css', $locator);
        $element = $this->getSession()->getPage()->find(
            'xpath',
            $xpath
        );
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not find element'));
        }
	//var_dump($element);

        $href = $element->getAttribute('href');
        $this->visit($href);

    
    }

    /**
     * @When /^(?:|I )wait for text "(?P<text>(?:[^"]|\\")*)" to appear$/
     * @Then /^(?:|I )should see "(?P<text>(?:[^"]|\\")*)" appear$/
     * @param $text
     * @throws \Exception
     */
    public function iWaitForTextToAppear($text)
    {
        $this->spin(function(FeatureContext $context) use ($text) {
            try {
                $context->assertPageContainsText($text);
                return true;
            }
            catch(ResponseTextException $e) {
                // NOOP
            }
            return false;
        });
    }


}

