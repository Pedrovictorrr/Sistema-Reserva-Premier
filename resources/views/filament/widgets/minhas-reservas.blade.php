<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Minhas Reservas
        </x-slot>

        <x-filament::modal slide-over width='5xl' icon="heroicon-o-exclamation-triangle" icon-color="primary"
            style="justify-content: center!important" class="button-product">
            <x-slot name="trigger" class="button-product">
                <button class="button-product" style="justify-content: center!important;justify-itens:center!important">
                    <section class="card  w-max card-blue bg-white mx-full dark:bg-gray-800 shadow-lg mb-4">
                        <div class="product-image rounded">
                            <img src="/images/teste01.jpg" class="img-product rounded" alt="OFF-white Blue Edition"
                                draggable="false" />
                        </div>
                        <div class="product-info">
                            <h5>
                                teste</h5>
                            <p>Quantidade: teste</p>
                            <p>Tamanho: teste</p>
                            <p>
                                <x-filament::badge color='info'>
                                    teste
                                </x-filament::badge>
                            </p>
                            <p>
                                <x-filament::badge color='success'>
                                    teste
                                </x-filament::badge>
                            </p>
                        </div>
                    </section>
                </button>
            </x-slot>
            <x-slot name="heading">
                Info
            </x-slot>

            <x-slot name="description">
                Descrição
            </x-slot>
            <hr>
            COntent
        </x-filament::modal>
        <style>
            .button-product {
                display: flex !important;
                justify-content: center !important;
                align-items: center !important;
            }

            .img-product {
                width: 100%;
                /* Define a largura da imagem como 100% da largura da div pai */
                height: 155px;
                /* Define a altura da imagem como 100% da altura da div pai */
                object-fit: cover;
                /* Garante que a imagem cubra completamente a área da div pai, mantendo sua proporção */
                object-position: center;
                /* Centraliza a imagem na div pai */
                user-select: none;
            }

            /*===== CARD =====*/
            .card {

                position: relative;
                padding: 1rem;
                width: auto;
                height: auto;
                /* box-shadow: -1px 15px 30px -12px rgb(32, 32, 32); */
                border-radius: 0.9rem;
                background-color: var(--red-card);
                color: var(--text);
                cursor: pointer;
                transform: translate(0, -0.5rem);
                transition: transform 200ms ease-in-out;
            }

            /* .card-blue {
                background-color: rgb(116, 116, 116);
            } */
            .product-image {
                height: auto;
                margin-bottom: 15px;
                object-fit: cover;
                align-items: center !important;
                /* filter: drop-shadow(5px 10px 15px rgba(8, 9, 13, 0.4)); */
            }

            .product-info {
                text-align: center;
                align-items: end !important;
                height: max-content !important;

            }

            .card:hover {
                transform: translate(-1.5rem, -4rem) rotate(-5deg);
            }

            .product-info h2 {
                font-size: 1.4rem;
                font-weight: 600;
            }

            .product-info p {
                margin: 0.4rem;
                font-size: 0.8rem;
                font-weight: 600;
            }

            .price {
                font-size: 1.2rem;
                font-weight: 500;
            }


            .buy-btn {
                background-color: var(--btn);
                padding: 0.6rem 3.5rem;
                font-weight: 600;
                font-size: 1rem;
                transition: 300ms ease;
            }

            .buy-btn:hover {
                background-color: var(--btn-hover);
            }

            .fav {
                box-sizing: border-box;
                background: #fff;
                padding: 0.5rem 0.5rem;
                border: 1px solid#000;
                display: grid;
                place-items: center;
            }


            .fav:hover .svg {
                fill: #000;
            }
        </style>
    </x-filament::section>
</x-filament-widgets::widget>
