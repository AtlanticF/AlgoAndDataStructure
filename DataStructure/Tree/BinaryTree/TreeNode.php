<?php

/**
 * 二叉树节点，链式存储
 */
class TreeNode
{
    public int $data;

    public TreeNode $left;
    public TreeNode $right;

    public function __construct(int $data, TreeNode $left = null, TreeNode $right = null)
    {
        $this->data = $data;
        $this->left = $left;
        $this->right = $right;
    }
}

$tree = new TreeNode(0);
$tree->left = new TreeNode(1);
$tree->right = new TreeNode(2);
var_dump($tree);