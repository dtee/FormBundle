<?php
namespace Dtc\FormBundle\Form;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;

abstract class FormHandler {
    protected $errorsProvider;
    protected $formFactory;
    protected $request;
    protected $form;

	/**
     * @return the $errorsProvider
     */
    public function getErrorsProvider()
    {
        return $this->errorsProvider;
    }

	/**
     * @return the $formFactory
     */
    public function getFormFactory()
    {
        return $this->formFactory;
    }

	/**
     * @return the $request
     */
    public function getRequest()
    {
        return $this->request;
    }

	/**
     * @param field_type $errorsProvider
     */
    public function setErrorsProvider(AjaxErrorProvider $errorsProvider)
    {
        $this->errorsProvider = $errorsProvider;
    }

	/**
     * @param field_type $formFactory
     */
    public function setFormFactory(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

	/**
     * @param field_type $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function getErrors() {
        return $this->errorsProvider->getErrors($this->getForm());
    }

    public function process() {
        $form = $this->getForm();
        $request = $this->request;

        $retVal = array();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                return $this->handleSuccess();
            }
            else {
                return false;
            }
        }

        return false;
    }

    abstract protected function handleSuccess();
    abstract public function getForm();
}