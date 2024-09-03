<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Atualizar Perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Atualize suas informações de localização.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Campos de endereço -->
        <div>
            <x-input-label for="cep" :value="__('CEP')" />
            <x-text-input id="cep" name="cep" type="text" class="mt-1 block w-full" :value="old('cep', $user->address->cep ?? '')" />
            <x-input-error :messages="$errors->update->get('cep')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="cidade" :value="__('Cidade')" />
            <x-text-input id="cidade" name="cidade" type="text" class="mt-1 block w-full" :value="old('cidade', $user->address->cidade ?? '')" />
            <x-input-error :messages="$errors->update->get('cidade')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="estado" :value="__('Estado')" />
            <x-text-input id="estado" name="estado" type="text" class="mt-1 block w-full" :value="old('estado', $user->address->estado ?? '')" />
            <x-input-error :messages="$errors->update->get('estado')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="rua" :value="__('Rua')" />
            <x-text-input id="rua" name="rua" type="text" class="mt-1 block w-full" :value="old('rua', $user->address->rua ?? '')" />
            <x-input-error :messages="$errors->update->get('rua')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Salvar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Salvo.') }}</p>
            @endif
        </div>
    </form>

    <script>
        document.getElementById('cep').addEventListener('blur', function() {
            const cep = this.value.replace(/\D/g, '');

            if (cep.length === 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('logradouro').value = data.logradouro;
                            document.getElementById('cidade').value = data.localidade;
                            document.getElementById('estado').value = data.uf;
                        } else {
                            alert('CEP não encontrado!');
                        }
                    })
                    .catch(error => console.error('Erro ao buscar o CEP:', error));
            } else {
                alert('CEP inválido!');
            }
        });
    </script>
</section>
