<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\DataTables\BannerDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Repositories\BannerRepository;
use DB;
use Exception;
use Flash;
use File;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\AppBaseController;
use Response;
use Storage;

class BannerController extends AppBaseController
{
    /** @var  BannerRepository */
    private $bannerRepository;

    public function __construct(BannerRepository $bannerRepo)
    {
        $this->bannerRepository = $bannerRepo;
    }

    /**
     * Display a listing of the Banner.
     *
     * @param  BannerDataTable  $bannerDataTable
     * @return mixed
     */
    public function index(BannerDataTable $bannerDataTable)
    {
        return $bannerDataTable->render('admin.banners.index');
    }

    /**
     * Show the form for creating a new Banner.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $latestOrder = Banner::max('order') + 1;
        return view('admin.banners.create', compact('latestOrder'));
    }

    /**
     * Store a newly created Banner in storage.
     *
     * @param  CreateBannerRequest  $request
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(CreateBannerRequest $request)
    {
        $dirpath = public_path('images/banners/');
        $filename = md5(str_replace([' ', '.'], '', microtime())).".jpg";
        $filepath = "{$dirpath}/{$filename}";

        try {
            DB::beginTransaction();
            $input = $request->all();
            $image = $request->file('image');

            $imgManager = Image::make($image);
            $imgManager->fit(1920, 639)
                ->encode('jpg', 70)
                ->save($filepath);

            $input['image'] = $filename;

            $this->bannerRepository->create($input);

            DB::commit();

            Flash::success('Banner salvo com sucesso.');
        } catch (Exception $ex) {
            DB::rollBack();

            File::delete($filepath);

            Flash::error('Erro ao cadastar banner');
        }
        return redirect(route('admin.banners.index'));
    }

    /**
     * Display the specified Banner.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(int $id)
    {
        $banner = $this->bannerRepository->find($id);

        if (empty($banner)) {
            Flash::error('Banner não encontrado');
            return redirect(route('admin.banners.index'));
        }

        $bannerImage = $banner->image;
        $banner->image = asset("images/banners/{$bannerImage}");

        return view('admin.banners.show')->with('banner', $banner);
    }

    /**
     * Show the form for editing the specified Banner.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(int $id)
    {
        $banner = $this->bannerRepository->find($id);

        if (empty($banner)) {
            Flash::error('Banner não encontrado');
            return redirect(route('admin.banners.index'));
        }

        $bannerImage = asset("images/banners/{$banner->image}");

        return view('admin.banners.edit', compact('banner', 'bannerImage'));
    }

    /**
     * Update the specified Banner in storage.
     *
     * @param  int  $id
     * @param  UpdateBannerRequest  $request
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function update(int $id, UpdateBannerRequest $request)
    {
        $banner = $this->bannerRepository->find($id);

        if (empty($banner)) {
            Flash::error('Banner não encontrado');
            return redirect(route('admin.banners.index'));
        }

        $dirpath = public_path('images/banners');
        $filename = md5(str_replace([' ', '.'], '', microtime())).".jpg";
        $filepath = "{$dirpath}/{$filename}";
        $oldFile = "";

        try {
            DB::beginTransaction();
            $input = $request->all();

            if ($request->hasFile('image')) {
                $oldFile = "{$dirpath}/{$banner->image}";
                $image = $request->file('image');

                $imgManager = Image::make($image);
                $imgManager->fit(1920, 639)
                    ->encode('jpg', 70)
                    ->save($filepath);

                $input['image'] = $filename;
            }

            $this->bannerRepository->update($input, $id);

            DB::commit();

            Flash::success('Banner atualizado com sucesso.');

            if (strlen($oldFile) > 0) {
                File::delete($oldFile);
            }
        } catch (Exception $ex) {
            DB::rollBack();

            File::delete($filepath);

            Flash::error('Erro ao atualizar banner');
        }
        return redirect(route('admin.banners.index'));
    }

    /**
     * Remove the specified Banner from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Exception|\Throwable
     */
    public function destroy(int $id)
    {
        $banner = $this->bannerRepository->find($id);

        if (empty($banner)) {
            Flash::error('Banner não encontrado');
            return redirect(route('admin.banners.index'));
        }

        $dirpath = public_path('images/banners');
        $oldFile = "{$dirpath}/{$banner->image}";

        try {
            DB::beginTransaction();

            $this->bannerRepository->delete($id);

            File::delete($oldFile);

            Flash::success('Banner excluído com sucesso.');

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Flash::error('Erro ao excluir banner!');
        }

        return redirect(route('admin.banners.index'));
    }
}
