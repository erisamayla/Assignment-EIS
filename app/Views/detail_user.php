<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<h2>Detail User</h2>

<ul class="list-group">
    <li class="list-group-item"><strong>Name:</strong> <?= $user['name'] ?></li>
    <li class="list-group-item"><strong>Email:</strong> <?= $user['email'] ?></li>
    <li class="list-group-item"><strong>Gender:</strong> <?= $user['gender'] ?></li>
    <li class="list-group-item"><strong>Hobbies:</strong>
        <?php 
            $hobbyArray = json_decode($user['hobbies'], true); 
            echo is_array($hobbyArray) ? implode(', ', $hobbyArray) : '-';
        ?>
    </li>
    <li class="list-group-item"><strong>Country:</strong> <?= $user['country'] ?></li>
    <li class="list-group-item"><strong>Status:</strong> <?= $user['status'] ? 'Active' : 'Inactive' ?></li>
</ul>

<a href="<?= base_url('user') ?>" class="btn btn-secondary mt-3">Kembali ke Daftar User</a>

<?= $this->endSection(); ?>
