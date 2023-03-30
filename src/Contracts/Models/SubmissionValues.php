<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Models;

interface SubmissionValues
{
    /**
     * Save the submission values.
     *
     * @return void
     */
    public function save(): self;

    /**
     * Delete the submission values.
     *
     * @return void
     */
    public function delete(): self;

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
}
