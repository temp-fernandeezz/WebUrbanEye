<x-base-layout>
    <section class="w-auto h-96 xl:h-screen bg-repeat-round bg-cover relative"
        style="background-image: url({{ Vite::asset('resources/images/bg-home.jpeg') }})">
        <div class="w-full  h-96 xl:h-screen absolute z-10 bg-black opacity-60 flex items-center justify-center">
            <div class="w-full max-w-screen-lg p-8 border-4 border-white h-96 content-center text-center">
                <h1 class="text-white text-3xl xl:text-5xl mb-8">
                    P.C.E - Pesquisa e Central de Enchentes
                </h1>
                <div class="flex flex-wrap lg:flex-nowrap justify-center gap-4 pt-6">
                    <a href="{{ route('location') }}">
                        <button
                            class="bg-gold-1 text-white py-2 px-6 border-2 border-gold-1 hover:bg-transparent hover:text-gold-1 transition">
                            Buscar Locais
                        </button>
                    </a>
                    <a href="{{ route('dashboard') }}">
                        <button
                            class="bg-transparent text-white py-2 px-6 border-2 border-white hover:bg-white hover:text-black transition">
                            Realizar Reclamação
                        </button>
                    </a>

                </div>
            </div>
        </div>
    </section>

    <section class="bg-musgo">
        <div class="mx-auto max-w-7xl">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-12 justify-center p-14">
                <div>
                    <div>
                        <p class="text-white text-3xl pb-12 font-semibold title-home">
                            Sobre Nós
                        </p>
                    </div>
                    <div>
                        <p class="text-white text-lg">
                            Com funcionalidades que incluem descrições, fotos e a localização exata, nosso objetivo é
                            facilitar a comunicação de problemas urbanos e colaborar para um ambiente mais limpo e
                            seguro. Através de um painel administrativo, as denúncias são analisadas cuidadosamente,
                            sendo aprovadas ou rejeitadas conforme a necessidade.
                        </p>
                    </div>
                </div>

                <div>
                    <div>
                        <p class="text-white text-3xl pb-12 font-semibold title-home">
                            Nossa Missão
                        </p>
                    </div>
                    <div>
                        <p class="text-white text-lg">
                            Nossa missão é transformar o modo como as pessoas se relacionam com suas cidades, fornecendo
                            uma plataforma eficiente para a denúncia de problemas urbanos como alagamentos e descarte
                            irregular de lixo. Acreditamos que a participação ativa dos cidadãos é essencial para a
                            construção de comunidades mais limpas e seguras.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="mx-auto max-w-7xl">
            <div class="text-center pb-20">
                <h2 class="text-3xl xl:text-4xl text-musgo pt-10 title-home">
                    Seviços da P.C.E - Pesquisa e Central de Enchentes
                </h2>
            </div>
            <div class="mx-auto text-center">
                <p class="text-xl text-musgo">
                    Explore os serviços especializados oferecidos pela P.C.E - Pesquisa e Central de Enchentes. Nossas
                    consultas e intervenções são projetadas para ajudá-lo a enfrentar com facilidade os desafios
                    relacionados às enchentes.
                </p>
            </div>

            <div class="pt-20">
                <div class="flex flex-col lg:flex-row items-center relative">
                    <div class="w-full md:w-1/2">
                        <img src="{{ Vite::asset('resources/images/photo-sub.jpeg') }}" alt="Research and Consultations"
                            class="w-full h-auto">
                    </div>
                    <div class="w-full md:w-1/2 lg:pl-8 pl-0 mt-4 md:mt-0">
                        <h2 class="text-2xl font-bold mb-4 lg:pt-0 pt-6">Pesquisas e Consultas</h2>
                        <p>Beneficie-se da pesquisa e das consultas a diferentes locais da P.C.E. Os nossos DEV's estão
                            empenhados em compreender a dinâmica das áreas propensas a inundações e em fornecer locais
                            precisos para mitigar os riscos de forma eficaz. Experimente uma abordagem para sua
                            necessidade de inundações que prioriza sua segurança e bem-estar</p>
                    </div>
                    <div
                        class="absolute left-1/2 transform -translate-x-1/2 hidden -translate-y-1/2 bg-white border-2 border-gray-300 rounded-full w-8 h-8 lg:flex items-center justify-center text-gold-1 text-lg font-bold">
                        1
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="flex flex-col lg:flex-row items-center mb-24 relative">
                    <div class="w-full md:w-1/2 order-2 md:order-1 lg:pr-8 pr-0 mt-4 md:mt-0">
                        <h2 class="text-2xl font-bold mb-4 lg:pt-0 pt-6">Gerenciamento de Reclamacoes</h2>
                        <p>Aproveite os serviços de gestão de reclamações da P.C.E para manter nossos mapas atualizados.
                            Nossa equipe garante que todas as preocupações sejam ouvidas e atendidas quando possivél,
                            promovendo um ambiente responsivo e de apoio.</p>
                    </div>
                    <div class="w-full md:w-1/2 order-1 md:order-2">
                        <img src="{{ Vite::asset('resources/images/car-sub.jpeg') }}" alt="Complaint Management"
                            class="w-full h-auto lg:pt-0 pt-6">
                    </div>
                    <div
                        class="absolute left-1/2 transform -translate-x-1/2 hidden -translate-y-1/2 bg-white border-2 border-gray-300 rounded-full w-8 h-8 lg:flex items-center justify-center text-gold-1 text-lg font-bold">
                        2
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="w-auto h-96 bg-repeat-round bg-cover relative"
        style="background-image: url({{ Vite::asset('resources/images/bg-news.jpeg') }});">
        <div class="w-full h-96 absolute z-10 bg-black opacity-60 flex items-center justify-center">
            <div class="w-full max-w-screen-lg content-center text-center">
                <h1 class="text-white text-5xl mb-8">
                    Mantenha-se sempre informado com o nosso <i>blog</i>.
                </h1>
                <div class="flex justify-center gap-4 pt-6">
                    <a href="{{ route('blog') }}">
                        <button
                            class="bg-transparent text-white py-2 px-6 border-2 border-white hover:bg-white hover:text-black transition">
                            Blog
                        </button>
                    </a>

                </div>
            </div>
        </div>
    </section>
</x-base-layout>
