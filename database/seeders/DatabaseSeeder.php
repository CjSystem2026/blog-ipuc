<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\PrayerRequest;
use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Usuarios Principales
        $admin = User::firstOrCreate(
            ['email' => 'admin@vocesdegracia.com'],
            [
                'name' => 'Pastor Alexander',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        $writer = User::firstOrCreate(
            ['email' => 'writer@vocesdegracia.com'],
            [
                'name' => 'Escritor Juan',
                'password' => bcrypt('password'),
                'role' => 'writer',
            ]
        );

        // 2. Usuarios Adicionales (Escritores de la Comunidad)
        $writer2 = User::firstOrCreate(
            ['email' => 'carlos@vocesdegracia.com'],
            [
                'name' => 'Diácono Carlos Mendoza',
                'password' => bcrypt('password'),
                'role' => 'writer',
            ]
        );

        $writer3 = User::firstOrCreate(
            ['email' => 'diana@vocesdegracia.com'],
            [
                'name' => 'Hermana Diana Cardona',
                'password' => bcrypt('password'),
                'role' => 'writer',
            ]
        );

        $writer4 = User::firstOrCreate(
            ['email' => 'martha@vocesdegracia.com'],
            [
                'name' => 'Pastora Martha Ortiz',
                'password' => bcrypt('password'),
                'role' => 'writer',
            ]
        );

        // 3. Artículos (Posts)
        $postsData = [
            [
                'slug' => 'la-gracia-salvadora-de-jesucristo',
                'title' => 'La gracia salvadora de Jesucristo',
                'excerpt' => 'Un análisis breve y reflexivo sobre el don inmerecido de la salvación y el impacto de la cruz.',
                'content' => "La salvación es un regalo de Dios, no por obras, para que nadie se gloríe. A través de la historia, la humanidad ha intentado acercarse a Dios por sus propios medios: sacrificios, rituales y códigos morales. Sin embargo, la brecha del pecado solo pudo ser cerrada por el sacrificio perfecto de Jesucristo en la cruz.\n\nAl recibir este don por la fe, somos transformados y llamados a vivir vidas que reflejen esa gracia inefable. Descansa hoy en la suficiencia de su obra consumada en el Calvario.",
                'image_path' => 'https://images.unsplash.com/photo-1507434965515-61970f2bd7c6?w=800&auto=format&fit=crop&q=60',
                'author_id' => $admin->id,
            ],
            [
                'slug' => 'el-poder-de-la-oracion-en-familia',
                'title' => 'El poder de la oración en familia',
                'excerpt' => 'Reflexiones y consejos prácticos para cultivar un altar familiar de oración en el hogar.',
                'content' => "La oración en familia es uno de los pilares más fuertes para la edificación del hogar. Cuando nos reunimos para orar, enseñamos a nuestros hijos a depender de Dios y a presentar sus necesidades ante Su trono. El altar familiar fortalece la comunión y nos ayuda a sobrellevar las cargas juntos, reconociendo que de Dios proviene nuestra paz y dirección.",
                'image_path' => 'https://images.unsplash.com/photo-1544764200-d834fd210a23?w=800&auto=format&fit=crop&q=60',
                'author_id' => $admin->id,
            ],
            [
                'slug' => 'caminando-en-santidad-y-temor-de-dios',
                'title' => 'Caminando en santidad y temor de Dios',
                'excerpt' => 'Una exhortación bíblica sobre la importancia de vivir una vida apartada para el servicio del Señor.',
                'content' => "La santidad no es una meta inalcanzable, sino un estilo de vida que agrada a Dios. En un mundo lleno de distracciones y tentaciones, la Iglesia es llamada a brillar con una conducta íntegra. Caminar en santidad implica guardar nuestro corazón, renovar nuestra mente con la Palabra de Dios y buscar la dirección del Espíritu Santo en cada decisión cotidiana.",
                'image_path' => 'https://images.unsplash.com/photo-1544764200-d834fd210a23?w=800&auto=format&fit=crop&q=60',
                'author_id' => $admin->id,
            ],
            [
                'slug' => 'la-adoracion-que-agrada-al-padre',
                'title' => 'La adoración que agrada al Padre',
                'excerpt' => 'Explorando el significado de adorar en espíritu y en verdad, más allá de la música o la liturgia.',
                'content' => "Jesús le dijo a la mujer samaritana que el Padre busca adoradores que le adoren en espíritu y en verdad. La verdadera adoración trasciende los cantos y las expresiones externas; es una actitud constante del corazón rendido ante Dios. Cuando nuestra vida diaria refleja obediencia y amor por el Señor, estamos ofreciendo un sacrificio vivo y agradable.",
                'image_path' => 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=800&auto=format&fit=crop&q=60',
                'author_id' => $writer->id,
            ],
            [
                'slug' => 'esperanza-en-tiempos-de-dificultad',
                'title' => 'Esperanza en tiempos de dificultad',
                'excerpt' => 'Promesas bíblicas para mantener la fe y la fortaleza en medio de las pruebas de la vida.',
                'content' => "Todos enfrentamos temporadas de prueba, dolor o incertidumbre. Sin embargo, la Biblia nos recuerda que el Señor es nuestro pronto auxilio en las tribulaciones. Nuestra fe no se fundamenta en las circunstancias temporales, sino en el carácter inmutable de Dios. Él promete estar con nosotros todos los días, dándonos la paz que sobrepasa todo entendimiento.",
                'image_path' => 'https://images.unsplash.com/photo-1518156677180-95a2893f3e9f?w=800&auto=format&fit=crop&q=60',
                'author_id' => $writer2->id,
            ],
            [
                'slug' => 'la-gran-comision-predicando-el-evangelio',
                'title' => 'La gran comisión: Predicando el Evangelio',
                'excerpt' => 'Un llamado a la Iglesia para cumplir el mandato de Jesús de compartir las buenas nuevas de salvación.',
                'content' => "El último mandato de Jesús a sus discípulos fue ir por todo el mundo y predicar el evangelio a toda criatura. La evangelización no es una tarea opcional para unos pocos, sino la misión colectiva de la Iglesia. Al compartir nuestro testimonio y hablar del amor de Cristo, sembramos semillas de vida eterna en los corazones de quienes nos rodean.",
                'image_path' => 'https://images.unsplash.com/photo-1490730141103-6cac27aaab94?w=800&auto=format&fit=crop&q=60',
                'author_id' => $writer3->id,
            ]
        ];

        foreach ($postsData as $pData) {
            Post::firstOrCreate(['slug' => $pData['slug']], $pData);
        }

        // 4. Testimonios
        $testimonialsData = [
            [
                'name' => 'Andrés Restrepo',
                'content' => 'Hace unos meses me diagnosticaron una afección severa en la columna. Después de que el pastor y los hermanos oraron por mí en el altar de la iglesia, el dolor desapareció por completo. Los exámenes de control médico salieron impecables. ¡Toda la gloria sea para Jesucristo, nuestro Sanador!',
                'status' => 'approved',
            ],
            [
                'name' => 'Tatiana Rojas',
                'content' => 'Quiero testificar de la maravillosa provisión de Dios. Estábamos pasando una situación financiera muy compleja en casa, y cuando parecía no haber salida, recibí una llamada ofreciéndome una excelente vacante laboral que superaba todas nuestras expectativas. Dios provee siempre.',
                'status' => 'approved',
            ],
            [
                'name' => 'Familia Silva Ospina',
                'content' => 'Doy testimonio de la protección divina. El fin de semana pasado sufrimos un percance vial en carretera. Aunque el vehículo tuvo daños graves, ningún miembro de mi familia recibió un rasguño. Los ángeles del Señor acampan alrededor de los que le temen.',
                'status' => 'approved',
            ],
            [
                'name' => 'Gloria Restrepo',
                'content' => 'Testifico con alegría que mi hijo menor ha vuelto a los caminos del Señor después de 5 años de estar alejado de la congregación. La oración perseverante de una madre tiene poder.',
                'status' => 'pending', // Queda como pendiente para administración
            ],
            [
                'name' => 'Mateo Bermúdez',
                'content' => 'Dios sanó a mi abuela de neumonía cuando los médicos decían que era muy difícil por su edad. La fe mueve montañas.',
                'status' => 'pending',
            ]
        ];

        foreach ($testimonialsData as $tData) {
            Testimonial::firstOrCreate(['name' => $tData['name']], $tData);
        }

        // 5. Peticiones de Oración (Públicas y Privadas)
        $prayerRequestsData = [
            [
                'name' => 'Clara Inés Muñoz',
                'email' => 'clara.ines@gmail.com',
                'message' => 'Pido la oración unida por la restauración de mi hogar. Confío en que Dios ablande el corazón de mi cónyuge y que reine el amor y el perdón en nuestra familia.',
                'is_private' => false,
                'status' => 'active',
            ],
            [
                'name' => 'Héctor Fabio Valencia',
                'email' => 'hector.fabio@outlook.com',
                'message' => 'Pido oración por sanidad física. He estado experimentando dolores fuertes en mi cuerpo y necesito la fortaleza del Señor y su mano sanadora sobre mí.',
                'is_private' => false,
                'status' => 'active',
            ],
            [
                'name' => 'Hermana Luz Dary',
                'email' => 'luzdary@hotmail.com',
                'message' => 'Ruego sus oraciones por mi hijo Julián, para que el Señor abra una puerta de empleo digno para él. Lleva varios meses buscando y se siente desanimado.',
                'is_private' => false,
                'status' => 'active',
            ],
            [
                'name' => 'Anónimo (Petición Reservada)',
                'email' => 'anonimo@test.com',
                'message' => 'Solicito oración privada por una situación familiar muy delicada que estamos afrontando en este momento. Agradezco la reserva y el respaldo espiritual de los pastores.',
                'is_private' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Familia Gómez',
                'email' => 'familia.gomez@gmail.com',
                'message' => 'Petición especial por sabiduría y dirección para un proyecto misionero y de emprendimiento familiar.',
                'is_private' => true,
                'status' => 'active',
            ]
        ];

        foreach ($prayerRequestsData as $prData) {
            PrayerRequest::firstOrCreate(['message' => $prData['message']], $prData);
        }

        // 6. Comentarios Ficticios en Artículos, Testimonios y Oraciones
        // Comentarios en Artículos
        $allPosts = Post::all();
        $sampleCommentTexts = [
            '¡Qué hermosa reflexión! De verdad que edifica grandemente mi vida en este día.',
            'Amén. La palabra de Dios siempre llega a tiempo.',
            'Excelente artículo. Compartiré esto con mis hermanos de la congregación.',
            '¡Gloria a Dios! Gracias por compartir estas verdades bíblicas tan profundas.',
            'Hermoso llamado a la santidad y a la dependencia del Espíritu Santo.'
        ];

        foreach ($allPosts as $post) {
            // Añadir un comentario de un escritor registrado
            Comment::create([
                'user_id' => $writer4->id,
                'guest_name' => null,
                'content' => $sampleCommentTexts[array_rand($sampleCommentTexts)],
                'commentable_id' => $post->id,
                'commentable_type' => Post::class,
            ]);

            // Añadir un comentario de un invitado
            Comment::create([
                'user_id' => null,
                'guest_name' => 'Hermano Felipe',
                'content' => 'Este artículo ha sido de gran edificación para mi familia. ¡Dios los bendiga!',
                'commentable_id' => $post->id,
                'commentable_type' => Post::class,
            ]);
        }

        // Comentarios en Testimonios aprobados
        $approvedTestimonials = Testimonial::where('status', 'approved')->get();
        foreach ($approvedTestimonials as $testimonial) {
            Comment::create([
                'user_id' => null,
                'guest_name' => 'Estela Gómez',
                'content' => '¡Gloria al Señor! Testimonios como este avivan nuestra fe y nos recuerdan que para Dios no hay nada imposible.',
                'commentable_id' => $testimonial->id,
                'commentable_type' => Testimonial::class,
            ]);

            Comment::create([
                'user_id' => $writer3->id,
                'guest_name' => null,
                'content' => '¡Qué gran bendición! Dios sigue obrando maravillas en medio de su pueblo.',
                'commentable_id' => $testimonial->id,
                'commentable_type' => Testimonial::class,
            ]);
        }

        // Comentarios en Peticiones de Oración públicas
        $publicPrayers = PrayerRequest::where('is_private', false)->get();
        foreach ($publicPrayers as $prayer) {
            Comment::create([
                'user_id' => null,
                'guest_name' => 'Hermana María',
                'content' => 'Amén, nos unimos en un solo sentir clamando al Padre celestial por esta necesidad.',
                'commentable_id' => $prayer->id,
                'commentable_type' => PrayerRequest::class,
            ]);

            Comment::create([
                'user_id' => $writer2->id,
                'guest_name' => null,
                'content' => 'Estaremos respaldando esta petición en el altar de oración familiar. Confiemos en su buena voluntad.',
                'commentable_id' => $prayer->id,
                'commentable_type' => PrayerRequest::class,
            ]);
        }

        // Seeder de Eventos / Actividades
        \App\Models\Event::create([
            'title' => 'Culto de Adoración y Acción de Gracias',
            'date' => now()->addDays(3)->toDateString(),
            'time' => '09:00 AM - 11:30 AM',
            'location' => 'Templo Central IPUC',
            'description' => 'Te invitamos a una reunión especial para agradecer a Dios por todas sus bendiciones. Trae a tu familia y amigos.',
            'image_path' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=800&auto=format&fit=crop&q=60',
        ]);

        \App\Models\Event::create([
            'title' => 'Seminario de Discipulado Familiar',
            'date' => now()->addDays(7)->toDateString(),
            'time' => '07:00 PM - 09:00 PM',
            'location' => 'Salón Anexo Central',
            'description' => 'Una jornada dedicada a fortalecer los lazos espirituales en el hogar bajo la guía de la palabra de Dios. Dirigido a padres e hijos.',
            'image_path' => 'https://images.unsplash.com/photo-1544764200-d834fd210a23?w=800&auto=format&fit=crop&q=60',
        ]);

        \App\Models\Event::create([
            'title' => 'Vigilia Juvenil de Confraternidad',
            'date' => now()->addDays(12)->toDateString(),
            'time' => '08:00 PM - 12:00 AM',
            'location' => 'Templo Central IPUC',
            'description' => 'Una noche de clamor, alabanza y comunión enfocada en la juventud. Nos acompañará el ministerio de alabanza de la zona 4.',
            'image_path' => 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=800&auto=format&fit=crop&q=60',
        ]);
    }
}
