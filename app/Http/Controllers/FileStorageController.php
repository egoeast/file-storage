<?php

namespace App\Http\Controllers;

use App\UserFile;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Mail;
use Intervention\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class FileStorageController extends Controller
{
    private $folder = '';
    protected $file_max_size = 10;
    protected $thumbnails = array(
        'pdf' => '/Thumbnail/pdf.png',
        'text' => '/Thumbnail/txt.png',
        'doc' => '/Thumbnail/doc.png',
        'zip' => '/Thumbnail/zip.png',
        'file' => '/Thumbnail/file.png',
    );

    const THUMBNAIL_FOLDER_PATH = '/Thumbnail/folder.png';
    const THUMBNAIL_PATH = '/thumbnail';
    const STORAGE_PATH = '/storage';
    const THUMBNAIL_SIZE = 300;

    /**
     * FileStorageController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['publicDownload', 'share']]);
        $this->middleware('blocking', ['except' => ['publicDownload', 'share']]);
        $this->middleware('activate', ['except' => ['publicDownload', 'share']]);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function createRootDirectory(User $user)
    {
        $path = public_path() . '/' . $user->name . $user->id;
        mkdir($path, 0777);
        mkdir($path . self::THUMBNAIL_PATH, 0777);
        $path .= self::STORAGE_PATH;
        mkdir($path, 0777);
        $root = $user->userFile()->create([
            'name' => 'My storage',
            'original_name' => $path,
            'path' => '/',
            'thumb_path' => self::THUMBNAIL_FOLDER_PATH,
            'f_type' => 'folder',
            'is_folder' => true,
            'folder_id' => 0,
        ]);
        return $root;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index()
    {
        $files = UserFile::where([
            ['user_id', '=', Auth::user()->id],
            ['folder_id', '=', 0]
        ])->first();

        //$file = $this->createRootDirectory(Auth::user());
        //dd($file);
        if ($files == NULL) {
            $files = $this->createRootDirectory(Auth::user());
        }
        if (\Session::has('folders')) {
            \Session::put('folders', []);
        }
        return redirect("/storage/$files->id");
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showFolder($id)
    {
        $file = UserFile::find($id);
        if ($file == Null)
            return view('errors.error');

        $folder = \Session::get('folders');
        $folder = array_add($folder, $id, $file->name);

        \Session::put('folders', $folder);
        \Session::put('current_folder_id', $id);

        $files = UserFile::where([
            ['user_id', '=', Auth::user()->id],
            ['folder_id', '=', $id]
        ])->orderBy('is_folder', 'desc')->paginate(12);

        return view('file_storage.index', compact('files'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function quickMove($id)
    {
        $folders = \Session::get('folders');
        $folders_temp = [];
        foreach ($folders as $key => $val) {
            if ($key != $id) {
                $folders_temp = array_add($folders_temp, $key, $val);
            } else break;
        }

        \Session::put('folders', $folders_temp);
        return redirect("/storage/$id");
    }

    /**
     * @return mixed
     */
    private function getFreeSpace()
    {
        return Auth::user()->max_disk_space - Auth::user()->disk_space;
    }

    /**
     * @param $filePath
     * @param $fileName
     */
    private function makeImageThumbnail($filePath, $fileName)
    {
        $thumbnail_path = $filePath . self::THUMBNAIL_PATH . '/' . $fileName;
        Image\Facades\Image::make(public_path() . $filePath . self::STORAGE_PATH . '/' . $fileName)->fit(self::THUMBNAIL_SIZE)->save(public_path() . $thumbnail_path);
    }

    /**
     * @param $file
     * @return array|string
     */
    private function defineFileThumbnail($file)
    {
        $thumbnail_path = '/Thumbnail/file.png';
        switch ($file->getMimeType()) {
            case 'application/pdf':
                $thumbnail_path = $this->thumbnails['pdf'];
                break;
            case 'text/plain':
                $thumbnail_path = $this->thumbnails['text'];
                break;
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                $thumbnail_path = $this->thumbnails['doc'];
                break;
            case 'application/zip':
                $thumbnail_path = $this->thumbnails['zip'];
                break;
            default:
                $thumbnail_path = $this->thumbnails['file'];
        }
        return $thumbnail_path;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function upload(Request $request)
    {

        if (Input::hasFile('uploadFile')) {
            foreach (Input::file('uploadFile') as $file) {
                if ($this->getFreeSpace() > $file->getSize() / (1024 * 1024)) {
                    if ($file->getSize() / (1024 * 1024) <= $this->file_max_size) {
                        $fileName = str_random(10);
                        $trueName = $file->getClientOriginalName();
                        $type = $file->getMimeType();
                        $filePath = '/' . Auth::user()->name . Auth::user()->id;
                        $size = $file->getSize() / 1024;
                        $disk_space = Auth::user()->disk_space + $size / 1024;
                        Auth::user()->update(['disk_space' => $disk_space]);
                        $file->move(public_path() . $filePath . self::STORAGE_PATH, $fileName);


                        //dd($this->defineFileThumbnail($file));

                        if (($type == 'image/jpeg') || ($type == 'image/png')) {
                            $thumbnail_path = $filePath . '/thumbnail/' . $fileName;
                            Image\Facades\Image::make(public_path() . $filePath . '/storage/' . $fileName)->fit(self::THUMBNAIL_SIZE)->save(public_path() . $thumbnail_path);
                        } elseif ($type == 'application/pdf') {
                            $thumbnail_path = '/Thumbnail/pdf.png';
                        } elseif ($type == 'text/plain') {
                            $thumbnail_path = '/Thumbnail/txt.png';
                        } elseif ($type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                            $thumbnail_path = '/Thumbnail/doc.png';
                        } elseif ($type == 'application/zip') {
                            $thumbnail_path = '/Thumbnail/zip.png';
                        } else {
                            $thumbnail_path = '/Thumbnail/file.png';
                        }

                        UserFile::create([
                            'name' => $fileName,
                            'user_id' => Auth::user()->id,
                            'original_name' => $trueName,
                            'path' => $filePath . '/storage/',
                            'f_type' => $type,
                            'size' => $size,
                            'thumb_path' => $thumbnail_path,
                            'folder_id' => \Session::get('current_folder_id'),
                        ]);
                        \Session::flash('flash_message', 'Your file has been uploaded!');
                    } else \Session::flash('flash_message_danger', "Your file " . $file->getClientOriginalName() . " is to big!");


                } else \Session::flash('flash_message_danger', "Not enough free disk space! Please delete some files and try again");
            }
        } else \Session::flash('flash_message_danger', "You did not specify a file path!");
        $cur_f = \Session::get('_previous');
        return redirect($cur_f['url']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function makeDir(Request $request)
    {

        $this->validate($request, [
            'directory_name' => 'required|max:255',
        ]);

        $files = UserFile::where([
            ['user_id', '=', Auth::user()->id],
            ['name', '=', $request->get('directory_name')],
            ['is_folder', '=', 1],
            ['folder_id', '=', \Session::get('current_folder_id')]
        ])->get();
        if (!$files->count()) {
            Auth::user()->userFile()->create([
                'name' => $request->get('directory_name'),
                'original_name' => '',
                'path' => '/',
                'thumb_path' => self::THUMBNAIL_FOLDER_PATH,
                'f_type' => 'folder',
                'is_folder' => true,
                'folder_id' => \Session::get('current_folder_id'),
            ]);
        } else \Session::flash('flash_message_danger', "Folder with this name already exist!");
        $cur_f = \Session::get('_previous');
        return redirect($cur_f['url']);
    }


    /**
     * @param $id
     * @return $this|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($id)
    {

        $file = UserFile::findOrFail($id);
        $file_path = public_path() . $file->path . $file->name;

        $headers = array(
            'Content-Type: image/jpeg',
            'Content-Type: image/png',
        );
        if (file_exists($file_path))
            return response()->download($file_path, $file->original_name, $headers);
        else return view('errors.error')->with('message', 'File does not exist');
    }

    /**
     * @param $id
     * @return $this|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function publicDownload($id)
    {

        $file = UserFile::findOrFail($id);
        $file_path = public_path() . $file->path . $file->name;

        $headers = array(
            'Content-Type: image/jpeg',
            'Content-Type: image/png',
        );
        if (file_exists($file_path))
            return response()->download($file_path, $file->original_name, $headers);
        else return view('errors.error')->with('message', 'File does not exist');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function makePublicLink($id)
    {

        $file = UserFile::findOrFail($id);
        $file->public_id = str_random(10);
        $file->save();

        $cur_f = \Session::get('_previous');
        //return redirect($cur_f['url']);
        return $file->public_id;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        $file = UserFile::findOrFail($id);
        \File::delete(public_path() . $file->path . $file->name);
        \File::delete(public_path() . $file->thumb_path . $file->name);

        $disk_space = Auth::user()->disk_space - ($file->size / 1024);
        Auth::user()->update(['disk_space' => $disk_space]);

        $file->delete();
        $cur_f = \Session::get('_previous');
        return redirect()->back();
    }

    /**
     * @param $public_id
     * @return $this
     */
    public function share($public_id)
    {
        $file = UserFile::where('public_id', '=', $public_id)->first();
        return view('file_storage.public_link')->with('file', $file);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $files = UserFile::where([
            ['user_id', '=', Auth::user()->id],
            ['original_name', 'LIKE', '%' . $request->get('search_str') . '%'],
            ['is_folder', '!=', 1],
        ])->get();

        return view('file_storage.search', compact('files'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function rename($id, Request $request)
    {
        $file = UserFile::findOrFail($id);
        $file->original_name = $request->firstname;
        $file->save();
        return $request->firstname;
    }

    /*
    public function test($id)
    {
        $file = UserFile::find($id);
        if ($file==Null)
            return view('errors.error');

        $folder =\Session::get('folders');
        $folder = array_add($folder,$id, $file->name);

        \Session::put('folders',$folder);
        \Session::put('current_folder_id',$id);

        $files = UserFile::where([
            ['user_id','=',Auth::user()->id],
            ['folder_id','=',$id]
        ])->orderBy('is_folder','desc')->paginate(12);

        return view('file_storage.test', compact('files'));
    }
    */
}
