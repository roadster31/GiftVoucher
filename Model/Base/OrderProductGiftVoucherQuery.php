<?php

namespace GiftVoucher\Model\Base;

use \Exception;
use \PDO;
use GiftVoucher\Model\OrderProductGiftVoucher as ChildOrderProductGiftVoucher;
use GiftVoucher\Model\OrderProductGiftVoucherQuery as ChildOrderProductGiftVoucherQuery;
use GiftVoucher\Model\Map\OrderProductGiftVoucherTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Thelia\Model\CartItem;
use Thelia\Model\Coupon;
use Thelia\Model\Order;

/**
 * Base class that represents a query for the 'order_product_gift_voucher' table.
 *
 *
 *
 * @method     ChildOrderProductGiftVoucherQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildOrderProductGiftVoucherQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method     ChildOrderProductGiftVoucherQuery orderByCartItemId($order = Criteria::ASC) Order by the cart_item_id column
 * @method     ChildOrderProductGiftVoucherQuery orderByCouponId($order = Criteria::ASC) Order by the coupon_id column
 * @method     ChildOrderProductGiftVoucherQuery orderByCustomerMessage($order = Criteria::ASC) Order by the customer_message column
 * @method     ChildOrderProductGiftVoucherQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildOrderProductGiftVoucherQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildOrderProductGiftVoucherQuery groupById() Group by the id column
 * @method     ChildOrderProductGiftVoucherQuery groupByOrderId() Group by the order_id column
 * @method     ChildOrderProductGiftVoucherQuery groupByCartItemId() Group by the cart_item_id column
 * @method     ChildOrderProductGiftVoucherQuery groupByCouponId() Group by the coupon_id column
 * @method     ChildOrderProductGiftVoucherQuery groupByCustomerMessage() Group by the customer_message column
 * @method     ChildOrderProductGiftVoucherQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildOrderProductGiftVoucherQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildOrderProductGiftVoucherQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOrderProductGiftVoucherQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOrderProductGiftVoucherQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOrderProductGiftVoucherQuery leftJoinCartItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the CartItem relation
 * @method     ChildOrderProductGiftVoucherQuery rightJoinCartItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CartItem relation
 * @method     ChildOrderProductGiftVoucherQuery innerJoinCartItem($relationAlias = null) Adds a INNER JOIN clause to the query using the CartItem relation
 *
 * @method     ChildOrderProductGiftVoucherQuery leftJoinOrder($relationAlias = null) Adds a LEFT JOIN clause to the query using the Order relation
 * @method     ChildOrderProductGiftVoucherQuery rightJoinOrder($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Order relation
 * @method     ChildOrderProductGiftVoucherQuery innerJoinOrder($relationAlias = null) Adds a INNER JOIN clause to the query using the Order relation
 *
 * @method     ChildOrderProductGiftVoucherQuery leftJoinCoupon($relationAlias = null) Adds a LEFT JOIN clause to the query using the Coupon relation
 * @method     ChildOrderProductGiftVoucherQuery rightJoinCoupon($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Coupon relation
 * @method     ChildOrderProductGiftVoucherQuery innerJoinCoupon($relationAlias = null) Adds a INNER JOIN clause to the query using the Coupon relation
 *
 * @method     ChildOrderProductGiftVoucher findOne(ConnectionInterface $con = null) Return the first ChildOrderProductGiftVoucher matching the query
 * @method     ChildOrderProductGiftVoucher findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOrderProductGiftVoucher matching the query, or a new ChildOrderProductGiftVoucher object populated from the query conditions when no match is found
 *
 * @method     ChildOrderProductGiftVoucher findOneById(int $id) Return the first ChildOrderProductGiftVoucher filtered by the id column
 * @method     ChildOrderProductGiftVoucher findOneByOrderId(int $order_id) Return the first ChildOrderProductGiftVoucher filtered by the order_id column
 * @method     ChildOrderProductGiftVoucher findOneByCartItemId(int $cart_item_id) Return the first ChildOrderProductGiftVoucher filtered by the cart_item_id column
 * @method     ChildOrderProductGiftVoucher findOneByCouponId(int $coupon_id) Return the first ChildOrderProductGiftVoucher filtered by the coupon_id column
 * @method     ChildOrderProductGiftVoucher findOneByCustomerMessage(string $customer_message) Return the first ChildOrderProductGiftVoucher filtered by the customer_message column
 * @method     ChildOrderProductGiftVoucher findOneByCreatedAt(string $created_at) Return the first ChildOrderProductGiftVoucher filtered by the created_at column
 * @method     ChildOrderProductGiftVoucher findOneByUpdatedAt(string $updated_at) Return the first ChildOrderProductGiftVoucher filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildOrderProductGiftVoucher objects filtered by the id column
 * @method     array findByOrderId(int $order_id) Return ChildOrderProductGiftVoucher objects filtered by the order_id column
 * @method     array findByCartItemId(int $cart_item_id) Return ChildOrderProductGiftVoucher objects filtered by the cart_item_id column
 * @method     array findByCouponId(int $coupon_id) Return ChildOrderProductGiftVoucher objects filtered by the coupon_id column
 * @method     array findByCustomerMessage(string $customer_message) Return ChildOrderProductGiftVoucher objects filtered by the customer_message column
 * @method     array findByCreatedAt(string $created_at) Return ChildOrderProductGiftVoucher objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildOrderProductGiftVoucher objects filtered by the updated_at column
 *
 */
abstract class OrderProductGiftVoucherQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \GiftVoucher\Model\Base\OrderProductGiftVoucherQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\GiftVoucher\\Model\\OrderProductGiftVoucher', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOrderProductGiftVoucherQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOrderProductGiftVoucherQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \GiftVoucher\Model\OrderProductGiftVoucherQuery) {
            return $criteria;
        }
        $query = new \GiftVoucher\Model\OrderProductGiftVoucherQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildOrderProductGiftVoucher|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = OrderProductGiftVoucherTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrderProductGiftVoucherTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildOrderProductGiftVoucher A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, ORDER_ID, CART_ITEM_ID, COUPON_ID, CUSTOMER_MESSAGE, CREATED_AT, UPDATED_AT FROM order_product_gift_voucher WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildOrderProductGiftVoucher();
            $obj->hydrate($row);
            OrderProductGiftVoucherTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildOrderProductGiftVoucher|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OrderProductGiftVoucherTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OrderProductGiftVoucherTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(OrderProductGiftVoucherTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(OrderProductGiftVoucherTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderProductGiftVoucherTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the order_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderId(1234); // WHERE order_id = 1234
     * $query->filterByOrderId(array(12, 34)); // WHERE order_id IN (12, 34)
     * $query->filterByOrderId(array('min' => 12)); // WHERE order_id > 12
     * </code>
     *
     * @see       filterByOrder()
     *
     * @param     mixed $orderId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(OrderProductGiftVoucherTableMap::ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(OrderProductGiftVoucherTableMap::ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderProductGiftVoucherTableMap::ORDER_ID, $orderId, $comparison);
    }

    /**
     * Filter the query on the cart_item_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCartItemId(1234); // WHERE cart_item_id = 1234
     * $query->filterByCartItemId(array(12, 34)); // WHERE cart_item_id IN (12, 34)
     * $query->filterByCartItemId(array('min' => 12)); // WHERE cart_item_id > 12
     * </code>
     *
     * @see       filterByCartItem()
     *
     * @param     mixed $cartItemId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function filterByCartItemId($cartItemId = null, $comparison = null)
    {
        if (is_array($cartItemId)) {
            $useMinMax = false;
            if (isset($cartItemId['min'])) {
                $this->addUsingAlias(OrderProductGiftVoucherTableMap::CART_ITEM_ID, $cartItemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cartItemId['max'])) {
                $this->addUsingAlias(OrderProductGiftVoucherTableMap::CART_ITEM_ID, $cartItemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderProductGiftVoucherTableMap::CART_ITEM_ID, $cartItemId, $comparison);
    }

    /**
     * Filter the query on the coupon_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCouponId(1234); // WHERE coupon_id = 1234
     * $query->filterByCouponId(array(12, 34)); // WHERE coupon_id IN (12, 34)
     * $query->filterByCouponId(array('min' => 12)); // WHERE coupon_id > 12
     * </code>
     *
     * @see       filterByCoupon()
     *
     * @param     mixed $couponId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function filterByCouponId($couponId = null, $comparison = null)
    {
        if (is_array($couponId)) {
            $useMinMax = false;
            if (isset($couponId['min'])) {
                $this->addUsingAlias(OrderProductGiftVoucherTableMap::COUPON_ID, $couponId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($couponId['max'])) {
                $this->addUsingAlias(OrderProductGiftVoucherTableMap::COUPON_ID, $couponId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderProductGiftVoucherTableMap::COUPON_ID, $couponId, $comparison);
    }

    /**
     * Filter the query on the customer_message column
     *
     * Example usage:
     * <code>
     * $query->filterByCustomerMessage('fooValue');   // WHERE customer_message = 'fooValue'
     * $query->filterByCustomerMessage('%fooValue%'); // WHERE customer_message LIKE '%fooValue%'
     * </code>
     *
     * @param     string $customerMessage The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function filterByCustomerMessage($customerMessage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($customerMessage)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $customerMessage)) {
                $customerMessage = str_replace('*', '%', $customerMessage);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OrderProductGiftVoucherTableMap::CUSTOMER_MESSAGE, $customerMessage, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(OrderProductGiftVoucherTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(OrderProductGiftVoucherTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderProductGiftVoucherTableMap::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(OrderProductGiftVoucherTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(OrderProductGiftVoucherTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderProductGiftVoucherTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\CartItem object
     *
     * @param \Thelia\Model\CartItem|ObjectCollection $cartItem The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function filterByCartItem($cartItem, $comparison = null)
    {
        if ($cartItem instanceof \Thelia\Model\CartItem) {
            return $this
                ->addUsingAlias(OrderProductGiftVoucherTableMap::CART_ITEM_ID, $cartItem->getId(), $comparison);
        } elseif ($cartItem instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrderProductGiftVoucherTableMap::CART_ITEM_ID, $cartItem->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCartItem() only accepts arguments of type \Thelia\Model\CartItem or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CartItem relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function joinCartItem($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CartItem');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CartItem');
        }

        return $this;
    }

    /**
     * Use the CartItem relation CartItem object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\CartItemQuery A secondary query class using the current class as primary query
     */
    public function useCartItemQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCartItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CartItem', '\Thelia\Model\CartItemQuery');
    }

    /**
     * Filter the query by a related \Thelia\Model\Order object
     *
     * @param \Thelia\Model\Order|ObjectCollection $order The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function filterByOrder($order, $comparison = null)
    {
        if ($order instanceof \Thelia\Model\Order) {
            return $this
                ->addUsingAlias(OrderProductGiftVoucherTableMap::ORDER_ID, $order->getId(), $comparison);
        } elseif ($order instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrderProductGiftVoucherTableMap::ORDER_ID, $order->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByOrder() only accepts arguments of type \Thelia\Model\Order or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Order relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function joinOrder($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Order');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Order');
        }

        return $this;
    }

    /**
     * Use the Order relation Order object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\OrderQuery A secondary query class using the current class as primary query
     */
    public function useOrderQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrder($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Order', '\Thelia\Model\OrderQuery');
    }

    /**
     * Filter the query by a related \Thelia\Model\Coupon object
     *
     * @param \Thelia\Model\Coupon|ObjectCollection $coupon The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function filterByCoupon($coupon, $comparison = null)
    {
        if ($coupon instanceof \Thelia\Model\Coupon) {
            return $this
                ->addUsingAlias(OrderProductGiftVoucherTableMap::COUPON_ID, $coupon->getId(), $comparison);
        } elseif ($coupon instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrderProductGiftVoucherTableMap::COUPON_ID, $coupon->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCoupon() only accepts arguments of type \Thelia\Model\Coupon or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Coupon relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function joinCoupon($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Coupon');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Coupon');
        }

        return $this;
    }

    /**
     * Use the Coupon relation Coupon object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\CouponQuery A secondary query class using the current class as primary query
     */
    public function useCouponQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCoupon($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Coupon', '\Thelia\Model\CouponQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildOrderProductGiftVoucher $orderProductGiftVoucher Object to remove from the list of results
     *
     * @return ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function prune($orderProductGiftVoucher = null)
    {
        if ($orderProductGiftVoucher) {
            $this->addUsingAlias(OrderProductGiftVoucherTableMap::ID, $orderProductGiftVoucher->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the order_product_gift_voucher table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderProductGiftVoucherTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            OrderProductGiftVoucherTableMap::clearInstancePool();
            OrderProductGiftVoucherTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildOrderProductGiftVoucher or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildOrderProductGiftVoucher object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderProductGiftVoucherTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OrderProductGiftVoucherTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        OrderProductGiftVoucherTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            OrderProductGiftVoucherTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(OrderProductGiftVoucherTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(OrderProductGiftVoucherTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(OrderProductGiftVoucherTableMap::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(OrderProductGiftVoucherTableMap::UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(OrderProductGiftVoucherTableMap::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     ChildOrderProductGiftVoucherQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(OrderProductGiftVoucherTableMap::CREATED_AT);
    }

} // OrderProductGiftVoucherQuery
