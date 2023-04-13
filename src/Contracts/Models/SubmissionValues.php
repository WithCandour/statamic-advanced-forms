<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Models;

use Statamic\Fields\Blueprint;

interface SubmissionValues
{
    /**
     * Set a data key for this submission.
     *
     * @return self
     */
    public function set($key, $value);

    /**
     * Get a data key for this submission.
     *
     * @return mixed
     */
    public function get($key, $fallback = null);

    /**
     * Get or set the data for this submission.
     *
     * @param array
     */
    public function data($data = null);

    /**
     * Save the submission values.
     *
     * @param array $options
     * @return self
     */
    public function save(array $options = []);

    /**
     * Delete the submission values.
     *
     * @return void
     */
    public function delete();

     /**
     * Get the blueprint for these values.
     *
     * @return Blueprint
     */
    public function blueprint(): Blueprint;

    /**
     * Generate an augmented array of values.
     *
     * @return array
     */
    public function toAugmentedArray(): array;
}
