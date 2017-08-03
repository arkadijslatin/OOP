<?php

namespace core;

interface ValidatorInterface
{
	public function setSchema(array $schema);
	public function run(array $fields);
}
