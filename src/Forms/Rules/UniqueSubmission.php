<?php
 
namespace WithCandour\StatamicAdvancedForms\Forms\Rules;
 
use Closure;
use Illuminate\Contracts\Validation\InvokableRule;
use WithCandour\StatamicAdvancedForms\Models\Stache\Form;

class UniqueSubmission implements InvokableRule
{
    public function __construct(
        public Form $form,
        public string $field
    ) {
        $this->form = $form;
        $this->field = $field;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $this->form->submissionValues()
            ->each(function($submissionValue) use ($value, $fail, $attribute){
                if ($value === $submissionValue->data[$this->field]) {
                    $fail('The :attribute must be unique.');
                };
            });

    }
}