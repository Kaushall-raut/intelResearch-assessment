<?= $this->extend('layout') ?>
<?= $this->section('content') ?><h2>My Profile</h2>



<div class="card mb-3">
    <div class="card-body">
        <form method="post" action="/profile"><?= csrf_field() ?>
        <label class="form-label">Full name</label>
        <input class="form-control mb-3" name="full_name" value="<?= esc($profile['full_name']??'') ?>" required>
        <label class="form-label">Phone</label>
        <input class="form-control mb-3" name="phone" value="<?= esc($profile['phone']??'') ?>">
        <label class="form-label">Skills</label>
        <textarea class="form-control mb-3" name="skills"><?= esc($profile['skills']??'') ?></textarea>
        <label class="form-label">Experience</label><textarea class="form-control mb-3" name="experience"><?= esc($profile['experience']??'') ?></textarea>
        <label class="form-label">Summary</label>
        <textarea class="form-control mb-3" name="summary"><?= esc($profile['summary']??'') ?></textarea>
        <button class="btn btn-primary">Save profile</button></form></div></div>
        <div class="card"><div class="card-body">
            <h5>Resume</h5><?php if(!empty($profile['resume_path'])): ?><p>Resume uploaded. <a href="/resume/<?= (int)$profile['id'] ?>">View/download</a></p><?php endif; ?>
                <form method="post" action="profile/resume" enctype="multipart/form-data"><?= csrf_field() ?><input type="file" name="resume" class="form-control mb-3" accept=".pdf,.doc,.docx" required><button class="btn btn-outline-primary">Upload resume (max 5 MB)</button></form></div></div><?= $this->endSection() ?>
