<?php

declare(strict_types=1);

namespace app\commands;

use app\models\Author;
use app\models\Book;
use app\models\BookAuthor;
use Yii;
use yii\console\Controller;

class SeedController extends Controller
{
    public function actionIndex(): void
    {
        $this->stdout("Seeding database...\n");

        // Create authors
        $authors = $this->createAuthors();
        $this->stdout("Created " . count($authors) . " authors.\n");

        // Create books
        $books = $this->createBooks($authors);
        $this->stdout("Created " . count($books) . " books.\n");

        $this->stdout("Database seeded successfully!\n");
    }

    /**
     * Create authors
     *
     * @return Author[]
     */
    private function createAuthors(): array
    {
        $authorsData = [
            ['full_name' => 'Лев Толстой'],
            ['full_name' => 'Фёдор Достоевский'],
            ['full_name' => 'Александр Пушкин'],
            ['full_name' => 'Антон Чехов'],
            ['full_name' => 'Николай Гоголь'],
            ['full_name' => 'Иван Тургенев'],
            ['full_name' => 'Михаил Лермонтов'],
            ['full_name' => 'Александр Солженицын'],
            ['full_name' => 'Борис Пастернак'],
            ['full_name' => 'Владимир Набоков'],
        ];

        $authors = [];
        foreach ($authorsData as $data) {
            $author = Author::findOne(['full_name' => $data['full_name']]);
            if (!$author) {
                $author = new Author();
                $author->full_name = $data['full_name'];
                $author->save(false);
            }
            $authors[] = $author;
        }

        return $authors;
    }

    /**
     * Create books
     *
     * @param Author[] $authors
     * @return Book[]
     */
    private function createBooks(array $authors): array
    {
        $booksData = [
            [
                'title' => 'Война и мир',
                'year' => 1869,
                'isbn' => '978-5-17-123456-7',
                'description' => 'Эпический роман о войне 1812 года и жизни русского общества.',
                'author_indices' => [0], // Толстой
            ],
            [
                'title' => 'Анна Каренина',
                'year' => 1877,
                'isbn' => '978-5-17-123457-4',
                'description' => 'Роман о трагической любви замужней дамы.',
                'author_indices' => [0], // Толстой
            ],
            [
                'title' => 'Преступление и наказание',
                'year' => 1866,
                'isbn' => '978-5-17-123458-1',
                'description' => 'Психологический роман о студенте Раскольникове.',
                'author_indices' => [1], // Достоевский
            ],
            [
                'title' => 'Братья Карамазовы',
                'year' => 1880,
                'isbn' => '978-5-17-123459-8',
                'description' => 'Философский роман о трёх братьях.',
                'author_indices' => [1], // Достоевский
            ],
            [
                'title' => 'Евгений Онегин',
                'year' => 1833,
                'isbn' => '978-5-17-123460-5',
                'description' => 'Роман в стихах о жизни светского общества.',
                'author_indices' => [2], // Пушкин
            ],
            [
                'title' => 'Капитанская дочка',
                'year' => 1836,
                'isbn' => '978-5-17-123461-2',
                'description' => 'Исторический роман о пугачёвском восстании.',
                'author_indices' => [2], // Пушкин
            ],
            [
                'title' => 'Вишнёвый сад',
                'year' => 1904,
                'isbn' => '978-5-17-123462-9',
                'description' => 'Пьеса о продаже имения.',
                'author_indices' => [3], // Чехов
            ],
            [
                'title' => 'Три сестры',
                'year' => 1901,
                'isbn' => '978-5-17-123463-6',
                'description' => 'Драма о трёх сёстрах, мечтающих о Москве.',
                'author_indices' => [3], // Чехов
            ],
            [
                'title' => 'Мёртвые души',
                'year' => 1842,
                'isbn' => '978-5-17-123464-3',
                'description' => 'Поэма о похождениях Чичикова.',
                'author_indices' => [4], // Гоголь
            ],
            [
                'title' => 'Ревизор',
                'year' => 1836,
                'isbn' => '978-5-17-123465-0',
                'description' => 'Комедия о мнимом ревизоре.',
                'author_indices' => [4], // Гоголь
            ],
            [
                'title' => 'Отцы и дети',
                'year' => 1862,
                'isbn' => '978-5-17-123466-7',
                'description' => 'Роман о конфликте поколений.',
                'author_indices' => [5], // Тургенев
            ],
            [
                'title' => 'Герой нашего времени',
                'year' => 1840,
                'isbn' => '978-5-17-123467-4',
                'description' => 'Психологический роман о Печорине.',
                'author_indices' => [6], // Лермонтов
            ],
            [
                'title' => 'Архипелаг ГУЛАГ',
                'year' => 1973,
                'isbn' => '978-5-17-123468-1',
                'description' => 'Историческое исследование о советских лагерях.',
                'author_indices' => [7], // Солженицын
            ],
            [
                'title' => 'Доктор Живаго',
                'year' => 1957,
                'isbn' => '978-5-17-123469-8',
                'description' => 'Роман о жизни во время революции.',
                'author_indices' => [8], // Пастернак
            ],
            [
                'title' => 'Лолита',
                'year' => 1955,
                'isbn' => '978-5-17-123470-5',
                'description' => 'Роман о Гумберте Гумберте.',
                'author_indices' => [9], // Набоков
            ],
            [
                'title' => 'Защита Лужина',
                'year' => 1930,
                'isbn' => '978-5-17-123471-2',
                'description' => 'Роман о шахматисте.',
                'author_indices' => [9], // Набоков
            ],
            // Книги за 2025 год для отчета "Топ авторы"
            [
                'title' => 'Новое произведение Толстого',
                'year' => 2025,
                'isbn' => '978-5-17-202501-1',
                'description' => 'Современное произведение в стиле классика.',
                'author_indices' => [0], // Толстой
            ],
            [
                'title' => 'Современная драма',
                'year' => 2025,
                'isbn' => '978-5-17-202501-2',
                'description' => 'Новая драма от классика.',
                'author_indices' => [0], // Толстой
            ],
            [
                'title' => 'Философские размышления',
                'year' => 2025,
                'isbn' => '978-5-17-202501-3',
                'description' => 'Глубокие размышления о жизни.',
                'author_indices' => [1], // Достоевский
            ],
            [
                'title' => 'Психологический триллер',
                'year' => 2025,
                'isbn' => '978-5-17-202501-4',
                'description' => 'Современный психологический роман.',
                'author_indices' => [1], // Достоевский
            ],
            [
                'title' => 'Стихи нового времени',
                'year' => 2025,
                'isbn' => '978-5-17-202501-5',
                'description' => 'Сборник стихотворений.',
                'author_indices' => [2], // Пушкин
            ],
            [
                'title' => 'Современная комедия',
                'year' => 2025,
                'isbn' => '978-5-17-202501-6',
                'description' => 'Юмористическое произведение.',
                'author_indices' => [3], // Чехов
            ],
            [
                'title' => 'Драма современности',
                'year' => 2025,
                'isbn' => '978-5-17-202501-7',
                'description' => 'Современная драма.',
                'author_indices' => [3], // Чехов
            ],
            [
                'title' => 'Сатирическая повесть',
                'year' => 2025,
                'isbn' => '978-5-17-202501-8',
                'description' => 'Сатира на современное общество.',
                'author_indices' => [4], // Гоголь
            ],
            [
                'title' => 'Современный роман',
                'year' => 2025,
                'isbn' => '978-5-17-202501-9',
                'description' => 'Роман о современной жизни.',
                'author_indices' => [5], // Тургенев
            ],
            [
                'title' => 'Поэма о времени',
                'year' => 2025,
                'isbn' => '978-5-17-202501-10',
                'description' => 'Поэтическое произведение.',
                'author_indices' => [6], // Лермонтов
            ],
            [
                'title' => 'Историческое исследование',
                'year' => 2025,
                'isbn' => '978-5-17-202501-11',
                'description' => 'Новое историческое исследование.',
                'author_indices' => [7], // Солженицын
            ],
            [
                'title' => 'Современная проза',
                'year' => 2025,
                'isbn' => '978-5-17-202501-12',
                'description' => 'Прозаическое произведение.',
                'author_indices' => [7], // Солженицын
            ],
            [
                'title' => 'Лирические стихи',
                'year' => 2025,
                'isbn' => '978-5-17-202501-13',
                'description' => 'Сборник лирических стихотворений.',
                'author_indices' => [8], // Пастернак
            ],
            [
                'title' => 'Современный роман-антиутопия',
                'year' => 2025,
                'isbn' => '978-5-17-202501-14',
                'description' => 'Роман о будущем.',
                'author_indices' => [9], // Набоков
            ],
            [
                'title' => 'Экспериментальная проза',
                'year' => 2025,
                'isbn' => '978-5-17-202501-15',
                'description' => 'Экспериментальное произведение.',
                'author_indices' => [9], // Набоков
            ],
            [
                'title' => 'Третья книга Толстого за 2025',
                'year' => 2025,
                'isbn' => '978-5-17-202501-16',
                'description' => 'Еще одно произведение классика.',
                'author_indices' => [0], // Толстой
            ],
            [
                'title' => 'Третья книга Достоевского за 2025',
                'year' => 2025,
                'isbn' => '978-5-17-202501-17',
                'description' => 'Еще одно произведение классика.',
                'author_indices' => [1], // Достоевский
            ],
            [
                'title' => 'Третья книга Чехова за 2025',
                'year' => 2025,
                'isbn' => '978-5-17-202501-18',
                'description' => 'Еще одно произведение классика.',
                'author_indices' => [3], // Чехов
            ],
            [
                'title' => 'Третья книга Солженицына за 2025',
                'year' => 2025,
                'isbn' => '978-5-17-202501-19',
                'description' => 'Еще одно произведение классика.',
                'author_indices' => [7], // Солженицын
            ],
            [
                'title' => 'Третья книга Набокова за 2025',
                'year' => 2025,
                'isbn' => '978-5-17-202501-20',
                'description' => 'Еще одно произведение классика.',
                'author_indices' => [9], // Набоков
            ],
            // Книги с несколькими авторами
            [
                'title' => 'Совместный роман: Война и мир современности',
                'year' => 2025,
                'isbn' => '978-5-17-202501-21',
                'description' => 'Совместное произведение двух классиков о современной войне.',
                'author_indices' => [0, 1], // Толстой и Достоевский
            ],
            [
                'title' => 'Поэтический сборник классиков',
                'year' => 2025,
                'isbn' => '978-5-17-202501-22',
                'description' => 'Сборник стихов от великих поэтов.',
                'author_indices' => [2, 6, 8], // Пушкин, Лермонтов, Пастернак
            ],
            [
                'title' => 'Драматическая трилогия',
                'year' => 2025,
                'isbn' => '978-5-17-202501-23',
                'description' => 'Три пьесы от мастеров драмы.',
                'author_indices' => [3, 4], // Чехов и Гоголь
            ],
            [
                'title' => 'Философский диалог',
                'year' => 2025,
                'isbn' => '978-5-17-202501-24',
                'description' => 'Философские размышления двух мыслителей.',
                'author_indices' => [1, 5], // Достоевский и Тургенев
            ],
            [
                'title' => 'Историческая эпопея',
                'year' => 2025,
                'isbn' => '978-5-17-202501-25',
                'description' => 'Масштабное историческое произведение.',
                'author_indices' => [0, 7], // Толстой и Солженицын
            ],
            [
                'title' => 'Современная проза: Антология',
                'year' => 2025,
                'isbn' => '978-5-17-202501-26',
                'description' => 'Сборник прозаических произведений.',
                'author_indices' => [8, 9], // Пастернак и Набоков
            ],
            [
                'title' => 'Классики о любви',
                'year' => 2025,
                'isbn' => '978-5-17-202501-27',
                'description' => 'Сборник произведений о любви от разных авторов.',
                'author_indices' => [2, 3, 5], // Пушкин, Чехов, Тургенев
            ],
            [
                'title' => 'Эпическое полотно',
                'year' => 2025,
                'isbn' => '978-5-17-202501-28',
                'description' => 'Монументальное произведение о русской истории.',
                'author_indices' => [0, 1, 7], // Толстой, Достоевский, Солженицын
            ],
        ];

        $books = [];
        foreach ($booksData as $data) {
            $book = Book::findOne(['isbn' => $data['isbn']]);
            if (!$book) {
                $book = new Book();
                $book->title = $data['title'];
                $book->year = $data['year'];
                $book->isbn = $data['isbn'];
                $book->description = $data['description'];
                $book->save(false);

                // Attach authors
                foreach ($data['author_indices'] as $index) {
                    if (isset($authors[$index])) {
                        $bookAuthor = new BookAuthor();
                        $bookAuthor->book_id = $book->id;
                        $bookAuthor->author_id = $authors[$index]->id;
                        $bookAuthor->save(false);
                    }
                }
            }
            $books[] = $book;
        }

        return $books;
    }
}

