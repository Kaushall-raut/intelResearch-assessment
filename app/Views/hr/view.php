```php
<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">

    <h2><?= esc($candidate['full_name']) ?></h2>

    <div class="card">
        <div class="card-body">

            <p>
                <b>Email:</b>
                <?= esc($candidate['email']) ?>
            </p>

            <p>
                <b>Phone:</b>
                <?= esc($candidate['phone'] ?? '') ?>
            </p>

            <p>
                <b>Skills:</b>
                <?= nl2br(esc($candidate['skills'] ?? '')) ?>
            </p>

            <p>
                <b>Experience:</b>
                <?= nl2br(esc($candidate['experience'] ?? '')) ?>
            </p>

            <p>
                <b>Summary:</b>
                <?= nl2br(esc($candidate['summary'] ?? '')) ?>
            </p>

            <p>
                <b>Verification:</b>
                <?= esc(ucfirst($candidate['status'] ?? 'pending')) ?>
            </p>

            <?php if (!empty($candidate['resume_path'])): ?>
                <a
                    class="btn btn-outline-primary mb-3"
                    href="<?= site_url('resume/' . (int) $candidate['id']) ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    View Resume
                </a>
            <?php endif; ?>

            <div class="mt-3">

                <?php if (($candidate['status'] ?? 'pending') !== 'verified'): ?>
                    <form
                        class="d-inline"
                        method="post"
                        action="<?= site_url('hr/candidate/' . (int) $candidate['id'] . '/verify') ?>"
                    >
                        <?= csrf_field() ?>

                        <button
                            type="submit"
                            class="btn btn-success"
                        >
                            Verify Candidate
                        </button>
                    </form>
                <?php else: ?>
                    <span class="badge bg-success">
                        Candidate Verified
                    </span>
                <?php endif; ?>

                <form
                    class="d-inline"
                    method="post"
                    action="<?= site_url('hr/candidate/' . (int) $candidate['id'] . '/interview') ?>"
                >
                    <?= csrf_field() ?>

                    <button
                        type="submit"
                        class="btn btn-warning"
                    >
                        Send Interview Email
                    </button>
                </form>

            </div>

        </div>
    </div>

    <a
        class="btn btn-link mt-3"
        href="<?= site_url('hr') ?>"
    >
        Back to HR Dashboard
    </a>

</div>

<?= $this->endSection() ?>
```