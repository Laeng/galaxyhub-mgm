<x-sub-page website-name="MGM Lounge" title="{{ $title }}">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16" class="flex justify-center">
        <div class="w-full">
            <div class="bg-white rounded-lg p-4 lg:p-16">
                <h1 class="text-2xl lg:text-3xl font-bold text-center lg:text-left my-4 lg:mt-0 lg:mb-6">{{$title}}</h1>

                <div class="flex-col space-y-2 mb-4">
                    @foreach($alerts as $v)
                        <x-dynamic-component :component="'alert.' .$v[0]" :title="$v[1]">
                            {!! $v[2] !!}
                        </x-dynamic-component>
                    @endforeach
                </div>

                <div class="flex flex-col mb-4">
                    <x-table.simple :api-url="$applicantsListApi" :use-check-box="true" />
                </div>


                <div class="flex flex-col mb-4">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="overflow-hidden border border-gray-200 rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="w-4 px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <input aria-describedby="comments-description" name="comments" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                        </th>
                                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            닉네임
                                        </th>
                                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                                        </th>
                                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Role
                                        </th>
                                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="w-4 px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <input aria-describedby="comments-description" name="comments" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            Jane Cooper
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                            Regional Paradigm Technician
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                            jane.cooper@example.com
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                            Admin
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        </td>
                                    </tr>

                                    <!-- More people... -->
                                    </tbody>
                                </table>

                                <nav class="bg-white px-3 py-3 flex items-center justify-between border-t border-gray-200 sm:px-3" aria-label="Pagination">
                                    <div class="hidden sm:block">
                                        <p class="text-sm text-gray-700">
                                            <span class="font-medium">1</span>
                                            -
                                            <span class="font-medium">10</span>
                                            Total:
                                            <span class="font-medium">20</span>

                                        </p>
                                    </div>
                                    <div class="flex-1 flex justify-start sm:justify-end space-x-3">
                                        <x-button.filled.md-white>
                                            이전
                                        </x-button.filled.md-white>
                                        <x-button.filled.md-white>
                                            다음
                                        </x-button.filled.md-white>
                                    </div>
                                </nav>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </x-section.basic>
</x-sub-page>
