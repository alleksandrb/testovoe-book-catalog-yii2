<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Добро пожаловать';
?>
<div class="site-index">
    <div class="hero-section text-center py-5 mb-5">
        <div class="container">
            <h1 class="display-3 fw-bold mb-4">Каталог книг</h1>
            <p class="lead mb-4">Добро пожаловать в наш каталог книг. Здесь вы можете найти информацию о книгах, авторах и подписаться на уведомления о новых произведениях ваших любимых писателей.</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <?= Html::a('Просмотреть книги', ['/book/index'], ['class' => 'btn btn-primary btn-lg']) ?>
                <?= Html::a('Просмотреть авторов', ['/author/index'], ['class' => 'btn btn-outline-primary btn-lg']) ?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
                                <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.81 8.985.936 8 1.783z"/>
                            </svg>
                        </div>
                        <h3 class="card-title">Книги</h3>
                        <p class="card-text">Просматривайте каталог книг с подробной информацией о каждой книге, включая описание, год издания и авторов.</p>
                        <?= Html::a('Перейти к книгам →', ['/book/index'], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                            </svg>
                        </div>
                        <h3 class="card-title">Авторы</h3>
                        <p class="card-text">Изучайте информацию об авторах и их произведениях. Подписывайтесь на уведомления о новых книгах ваших любимых писателей.</p>
                        <?= Html::a('Перейти к авторам →', ['/author/index'], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07Z"/>
                            </svg>
                        </div>
                        <h3 class="card-title">Отчеты</h3>
                        <p class="card-text">Просматривайте статистику и отчеты о самых популярных авторах и их книгах в каталоге.</p>
                        <?= Html::a('Перейти к отчетам →', ['/report/top-authors'], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 0 0 2rem 2rem;
    margin-top: -1rem;
}

.hero-section h1 {
    color: white;
}

.hero-section .btn-primary {
    background-color: white;
    color: #667eea;
    border: none;
}

.hero-section .btn-primary:hover {
    background-color: #f8f9fa;
    color: #667eea;
}

.hero-section .btn-outline-primary {
    background-color: transparent;
    color: white;
    border: 2px solid white;
}

.hero-section .btn-outline-primary:hover {
    background-color: white;
    color: #667eea;
}

.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-5px);
}

.card svg {
    color: #667eea;
}
</style>
