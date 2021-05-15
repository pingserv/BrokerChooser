<?php

namespace App\Classes;

use App\Models\Challenge;
use App\Models\Session;
use Illuminate\Http\Request;

class Challenger
{
    private $variants;
    private $session;
    private $request;
    private $challenge;

    public function __construct(Request $request, Session $session)
    {
        $this->request = $request;
        $this->session = $session;
    }

    public function register($name)
    {
        $this->challenge = Challenge::firstOrCreate([
            'name' => $name,
            'status' => 'started'
        ]);

        return $this;
    }

    public function variant($name, $ratio)
    {
        $this->challenge->variants()->firstOrCreate([
            'name' => $name,
            'ratio' => $ratio
        ]);

        ob_start(function ($content) use ($name, $ratio) {
            $this->variants[$name] = [
                'name' => $name,
                'ratio' => $ratio,
                'content' => $content
            ];
        });
    }

    public function endVariant()
    {
        ob_end_clean();
    }

    public function show()
    {
        if ($this->challenge->status != 'started') {
            return false;
        }

        if (!$variant = $this->hasVariant()) {
            $variant = $this->getVariant();
        }

        if ($this->request->getMethod() === 'GET' && !$this->request->isXmlHttpRequest()) {
            $this->session->events()->create([
                'category' => $this->challenge->name,
                'action' => 'hit',
                'label' => $variant['name'],
                'url' => url($this->request->path())
            ]);
        }

        return $variant['content'];
    }

    private function hasVariant()
    {
        $query = $this->session->events()->where('action', 'hit');
        if ($query->exists()) {
            $variant_name = $query->first()->label;
            return $this->variants[$variant_name];
        }

        return false;
    }

    private function getVariant()
    {
        $current = 0;
        $random = mt_rand(0, array_sum(array_column($this->variants,'ratio')) * 100) / 100;

        foreach($this->variants as $key => $val) {
            $current += $val['ratio'];
            if($current >= $random) {
                return $this->variants[$key];
            }
        }
    }

    public function goal($name)
    {
        if ($this->request->getMethod() === 'GET' && !$this->request->isXmlHttpRequest()) {
            $this->challenge = Challenge::whereHas('variants', function ($query) use($name) {
                return $query->where('name', $name);
            })->first();

            $this->session->events()->create([
                'category' => $this->challenge->name,
                'action' => 'goal',
                'label' => $name,
                'url' => url($this->request->path())
            ]);
        }
    }
}