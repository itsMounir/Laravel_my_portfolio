<x-layout>
    <section class="py-8  max-w-md mx-auto">
        <form action="/admin/posts" method="POST" enctype="multipart/form-data">
            @csrf
            <h1 class="text-xl font-bold mb-4">
                Publish a new post
            </h1>

                <div class="border border-gray-200 p-6 rounded-xl">
                    <div class="mb-6">
                        <label class="block mb-2 font-bold uppercase text-xs text-gray-700" for="title">
                            Title
                        </label>

                        <input type="text"
                            class="border border-gray-400 p-2 w-full" name="title" id="title" value="{{old('title')}}" required>

                        @error('title')
                            <p class="text-red-500 mt-1 text-xs"> {{$message}} </p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 font-bold uppercase text-xs text-gray-700" for="slug">
                            Slug
                        </label>

                        <input type="text"
                            class="border border-gray-400 p-2 w-full" name="slug" id="slug" value="{{old('slug')}}" required>

                        @error('slug')
                            <p class="text-red-500 mt-1 text-xs"> {{$message}} </p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 font-bold uppercase text-xs text-gray-700" for="thumbnail">
                            Thumbnail
                        </label>

                        <input type="file"
                            class="border border-gray-400 p-2 w-full" name="thumbnail" id="thumbnail" value="{{old('thumbnail')}}" required>

                        @error('thumbnail')
                            <p class="text-red-500 mt-1 text-xs"> {{$message}} </p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 font-bold uppercase text-xs text-gray-700" for="exerpts">
                            Exerpts
                        </label>

                        <textarea
                            class="border border-gray-400 p-2 w-full"
                            name="exerpts"
                            id="exerpts"
                            required>
                            {{old('exerpts')}}
                        </textarea>

                        @error('exerpts')
                            <p class="text-red-500 mt-1 text-xs"> {{$message}} </p>
                        @enderror
                    </div>



                    <div class="mb-6">
                        <label class="block mb-2 font-bold uppercase text-xs text-gray-700" for="body">
                            Body
                        </label>

                        <textarea
                            class="border border-gray-400 p-2 w-full" name="body" id="body" required>
                            {{old('body')}}
                        </textarea>

                        @error('body')
                            <p class="text-red-500 mt-1 text-xs"> {{$message}} </p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 font-bold uppercase text-xs text-gray-700" for="category_id">
                            Category
                        </label>

                        <select name="category_id" id="category_id">
                            @foreach (\App\Models\Category::all() as $category)
                                <option value="{{$category->id}}" {{old('category_id') == $category->id ? 'selected' : ''}}>{{ucwords($category->name)}}</option>
                            @endforeach
                        </select>

                        @error('category')
                            <p class="text-red-500 mt-1 text-xs"> {{$message}} </p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary bg-blue-500 text-white rounded-2xl py-2 px-4 hover:bg-blue-600">
                        Publish
                    </button>
                </div>

        </form>
    </section>
</x-layout>
