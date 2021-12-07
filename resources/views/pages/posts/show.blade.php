<x-app-layout>
    <x-slot name="header">
        @include('components/profile-header')
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 clearfix" id="feed">
                    <div class="row">
                        <div class="col-md-8">
                            <div id="postCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($post->photos as $photo)
                                        <div @class(["carousel-item", 'active' => $loop->index === 0])>
                                            <img src="{{ $photo->url }}" class="d-block w-100" alt="{{ __('Post photo') }}">
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#postCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#postCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col">
                                    <p class="fs-6">{{ $post->description }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p>{{ $post->created_at->format('d.m.Y, H:i') }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 m-3">
                                    <p>
                                        <a href="{{ route('likes.toggle', ['post' => $post]) }}" id="postLike" class="text-success">
                                            @if($post->likes->contains(auth()->user()))
                                                {{ __('Dislike') }}
                                            @else
                                                {{ __('Like') }}
                                            @endif
                                        </a>
                                        <a href="{{ route('likes.list', ['post' => $post]) }}" id="postLikeCounter" class="text-success">
                                            ({{ $post->likes_count }})
                                        </a>
                                    </p>
                                </div>
                                @if($post->user->id === auth()->id())
                                <div class="col-md-3 m-3">
                                    <p>
                                        <a href="{{ route('post.remove', ['post' => $post]) }}" id="postRemove" class="text-danger">
                                            {{ __('Delete') }}
                                        </a>
                                    </p>
                                </div>
                                @endif
                            </div>
                            <hr />
                            <div id="comments" class="row">
                                <div class="col mt-3" id="comments">
                                    <p class="text-muted">{{ __('No comments for this post') }}</p>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col mt-3" id="commentsForm">
                                    <p>{{ __('Write comment') }}</p>
                                    <form method="post">
                                        @csrf
                                        <textarea class="form-control"></textarea>
                                        <div class="mt-1 text-end">
                                            <button class="btn btn-primary">{{ __('Submit') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($post->user->id === auth()->id())
        <script>
            window.onload = function() {

                function get_profile_card(user) {
                    let details = user.details;
                    let card = document.createElement('div');
                    card.className = 'card mb-3';
                    let row = document.createElement('div');
                    row.className = 'row g-0';
                    let imageContainer = document.createElement('div');
                    imageContainer.className = 'col-md-4';
                    let image = document.createElement('img');
                    image.src = details.profile_photo;
                    image.alt = details.display_name;
                    image.title = details.display_name;
                    image.width = 100;
                    image.className = 'img-fluid rounded-start';
                    imageContainer.appendChild(image);
                    row.appendChild(imageContainer);
                    let bodyContainer = document.createElement('div');
                    bodyContainer.className = 'col-md-8';
                    let cardBody = document.createElement('div');
                    cardBody.className = 'card-body';
                    let title = document.createElement('h5');
                    title.className = 'card-title';
                    title.innerHTML = '<a href="/p/' + user.id + '" title="{{ __('View profile') }}">' + details.display_name + '</a>';
                    cardBody.appendChild(title);;
                    bodyContainer.appendChild(cardBody);
                    row.appendChild(bodyContainer);
                    card.appendChild(row);

                    return card;
                }

                function get_modal(title, content) {
                    let modal = document.createElement('div');
                    modal.className = 'modal';
                    modal.tabIndex = -1;
                    let dialog = document.createElement('div');
                    dialog.className = 'modal-dialog';
                    let modalContent = document.createElement('div');
                    modalContent.className = 'modal-content';
                    let header = document.createElement('div');
                    header.className = 'modal-header';
                    header.innerHTML = '<h5 class="modal-title">' + title + '</div>';
                    header.innerHTML += '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                    let body = document.createElement('div');
                    body.className = 'modal-body';
                    let footer = document.createElement('div');
                    footer.className = 'modal-footer';
                    footer.innerHTML = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
                    modalContent.appendChild(header);
                    body.appendChild(content);
                    modalContent.appendChild(body);
                    modalContent.appendChild(footer);
                    dialog.appendChild(modalContent);
                    modal.appendChild(dialog);

                    return modal;
                }


                document.getElementById('postRemove').addEventListener('click', (event) => {
                    event.preventDefault();
                    event.stopPropagation();
                    let confirm = window.confirm('{{ __('Are you sure you want to remove this post?') }}');
                    if (confirm) {
                        axios.delete(event.target.href).then((response) => {
                            if (response.status === 204) {
                                window.location.href = '{{ route('profile', ['user' => auth()->user()]) }}';
                            } else {
                                window.alert('{{ __('There was an error while deleting the post') }}');
                            }
                        });
                    }
                });

                document.getElementById('postLike').addEventListener('click', (event) => {
                    event.preventDefault();
                    event.stopPropagation();
                    axios.post(event.target.href).then((response) => {
                        if (response.status === 200) {
                            let count = response.data.likes_count;
                            document.getElementById('postLikeCounter').innerHTML = '('+count+')';
                            event.target.innerText = response.data.label;
                        }
                    });
                });

                document.getElementById('postLikeCounter').addEventListener('click', (event) => {
                    event.preventDefault();
                    event.stopPropagation();
                    axios.get(event.target.href).then((response) => {
                        let listGroup = document.createElement('ul');
                        listGroup.className = 'list-group';
                        for (let i in response.data) {
                            let profile = response.data[i];
                            let item = document.createElement('li');
                            item.className = 'list-group-item';
                            item.appendChild(get_profile_card(profile));
                            listGroup.appendChild(item);
                        }

                        (new bootstrap.Modal(get_modal('Users who liked this post', listGroup))).show();
                    });
                });

            };
        </script>
        @endif
    </div>

</x-app-layout>
