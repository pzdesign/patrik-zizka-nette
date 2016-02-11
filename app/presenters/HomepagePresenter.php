<?php

namespace App\Presenters;

use Nette;
use App\Model,
    Nette\Application\UI\Form,
    Nette\Forms\Controls,
    Nette\Utils\Html,
    Nette\Mail\Message,
    Nette\Utils\Finder,
    Nette\Mail\SendmailMailer;

class HomepagePresenter extends BasePresenter
{

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

    /**
     * Contact form
     */
    protected function createComponentContactForm()
    {

// vytvoříme element
        $products = array(
    'Zakladni' => 'Základní',
    'Pokrocile' => 'Pokročilé',
    'NaMiru' => 'Na Míru',
    'Ostatni' => 'Ostatní'
);


        $form = new Form;

        $form->addText('name', 'Jméno ')
             ->addRule(Form::FILLED, 'Zadejte jméno');
        $form->addSelect('product', 'Produkt:', $products)
             ->setRequired()->setDefaultValue('Zakladni');

        $form->addText('phone', 'Telefon ');

        $form->addText('email', 'Email')
             ->addRule(Form::FILLED, 'Zadejte email')
             ->addRule(Form::EMAIL, 'Email nemá správný formát');
        $form->addTextarea('message', 'Zpráva', 999, 5)
             ->addRule(Form::FILLED, 'Zadejte zprávu');
        $form->addSubmit('send', 'Odeslat');

// setup form rendering
$renderer = $form->getRenderer();
$renderer->wrappers['controls']['container'] = NULL;
$renderer->wrappers['pair']['container'] = 'div class=form-group';
$renderer->wrappers['pair']['.error'] = 'has-error';
$renderer->wrappers['control']['container'] = 'div class=col-sm-12';
$renderer->wrappers['label']['container'] = 'div class="col-sm-12  text-center"';
$renderer->wrappers['control']['description'] = 'span class=help-block';
$renderer->wrappers['control']['errorcontainer'] = 'span class=help-block';

// make form and controls compatible with Twitter Bootstrap
$form->getElementPrototype()->class('form-horizontal');
foreach ($form->getControls() as $control) {
    if ($control instanceof Controls\Button) {
        $control->getControlPrototype()->addClass(empty($usedPrimary) ? 'btn btn-green btn-block btn-lg' : 'btn btn-default');
        $usedPrimary = TRUE;
    } elseif ($control instanceof Controls\TextBase || $control instanceof Controls\SelectBox || $control instanceof Controls\MultiSelectBox) {
        $control->getControlPrototype()->addClass('form-control');
    } elseif ($control instanceof Controls\Checkbox || $control instanceof Controls\CheckboxList || $control instanceof Controls\RadioList) {
        $control->getSeparatorPrototype()->setName('div')->addClass($control->getControlPrototype()->type);
    }
}

        $form->onSuccess[] = $this->processContactForm;
        return $form;
    }




    /**
     * Process contact form, send message
     * @param Form
     */
public function processContactForm(Form $form)
{

    $values = $form->getValues(TRUE);
    $mail = new Message;
    $mail->setFrom($values['email'])
         ->addTo('patrik.zizka.s@gmail.com')
         ->setSubject('Zpráva z kontaktního formuláře');


    $template = $this->createTemplate();
    $template->setFile(__DIR__ . '/templates/mail/emailTemplate.latte');
    $template->title = 'Zpráva z kontaktního formuláře';
    $template->values = $values;
    
    $mail->setHtmlBody($template);

    $mailer = new SendmailMailer;
    $mailer->send($mail);

    $this->flashMessage('Zpráva byla úspěšně odeslána', 'alert-success');
    $this->redirect('this');
}
}
