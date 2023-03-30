<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Models;

use Carbon\Carbon;
use WithCandour\StatamicAdvancedForms\Models\NoteType;

interface Note
{
    /**
     * Get the ID of this note.
     *
     * @return int
     */
    public function id(): int;

    /**
     * Get the submission for this note.
     *
     * @return Submission
     */
    public function submission(): Submission;

    /**
     * Set the submission for this note.
     *
     * @param Submission $submission
     * @return self
     */
    public function setSubmission(Submission $submission): self;

    /**
     * Get the type for the note.
     *
     * @return NoteType
     */
    public function noteType(): NoteType;

    /**
     * Set the type for the note.
     *
     * @param NoteType $type
     * @return self
     */
    public function setNoteType(NoteType $type): self;

    /**
     * Get the note text for this note.
     *
     * @return string|null
     */
    public function note(): ?string;

    /**
     * Set the note text for this note.
     *
     * @param string $note
     * @return self
     */
    public function setNote(string $note): self;

    /**
     * Get the date for this note.
     *
     * @return Carbon
     */
    public function date(): Carbon;
}
