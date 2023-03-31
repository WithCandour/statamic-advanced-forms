<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Models;

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
}
